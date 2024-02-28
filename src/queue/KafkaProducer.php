<?php

namespace Utils\queue;

use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;

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
                printf('Message FAILED (%s, %s) to send with payload => %s', $message->err, $errorStr, $message->payload) . PHP_EOL;
            } else {
                printf('Message sent SUCCESSFULLY with payload => %s', $message->payload) . PHP_EOL;
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
        $this->producer->flush(-1);
    }
}
