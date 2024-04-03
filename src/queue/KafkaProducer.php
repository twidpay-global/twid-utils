<?php

namespace Utils\queue;

use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;
use twid\logger\Facades\TLog;

class KafkaProducer
{
    private $producer;
    private $conf;

    public function __construct(array $config = [])
    {
        $this->conf = new Conf();

        $this->setDefaultConfig();

        $this->mergeConfig($config);

        $this->initializeProducer();
    }

    private function setDefaultConfig()
    {
        $this->conf->set('metadata.broker.list', 'localhost:9092');
        $this->conf->set('client.id', 'twid-php-producer');
        $this->conf->set('compression.codec', 'snappy');
        $this->conf->set('message.timeout.ms', '5000');
    }

    private function mergeConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $this->conf->set($key, $value);
        }
    }

    private function initializeProducer()
    {
        $this->conf->setDrMsgCb(function (Producer $kafka, Message $message) {
            if (\RD_KAFKA_RESP_ERR_NO_ERROR !== $message->err) {
                $errorStr = \rd_kafka_err2str($message->err);
                TLog::error('Message sent FAILED with payload => ' . $message->payload . ' and error => ' . $errorStr);
            }
        });

        $this->producer = new Producer($this->conf);
    }

    public function produce(string $topic, string $message, string $key = null)
    {
        $topic = $this->producer->newTopic($topic, null);
        $partition = \RD_KAFKA_PARTITION_UA;

        if ($key === null) {
            $key = \Ramsey\Uuid\Uuid::uuid4()->toString();
        }

        $topic->producev($partition, \RD_KAFKA_MSG_F_BLOCK, $message, $key);

        // Flush with timeout and retries
        for ($flushRetries = 0; $flushRetries < 3; $flushRetries++) {
            $result = $this->producer->flush(5000);
            if ($result === RD_KAFKA_RESP_ERR_NO_ERROR) {
                break;
            }
        }

    }
}
