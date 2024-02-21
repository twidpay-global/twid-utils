<?php

use PHPUnit\Framework\TestCase;
use Utils\queue\KafkaProducer;

class KafkaProducerTest extends TestCase
{
    private $kafkaProducer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kafkaProducer = new KafkaProducer();
    }

    public function testProduceMessage()
    {
        $topic = 'test-topic2';
        $message = 'Test message';
        $key = 'test-key';

        $this->kafkaProducer->produce($topic, $message, $key);
        $this->expectOutputString('Message sent SUCCESSFULLY with payload => Test message');
    }

    public function testProduceMessageWithoutKey()
    {
        $topic = 'test-topic2';
        $message = 'Test message';

        $this->kafkaProducer->produce($topic, $message);
        $this->expectOutputString('Message sent SUCCESSFULLY with payload => Test message');
    }

    public function testProduceMessageWithConfig()
    {
        $topic = 'test-topic3';
        $message = 'Test message';
        $key = 'test';


        $config = [
            'metadata.broker.list' => 'localhost:9092',
            'compression.codec' => 'snappy',
            'message.timeout.ms' => '5000',
            'client.id' => 'php-produce2r',
        ];

        $this->kafkaProducer = new KafkaProducer($config);

        $this->kafkaProducer->produce($topic, $message, $key);
        $this->expectOutputString('Message sent SUCCESSFULLY with payload => Test message');
    }

    public function testProduceMessageWithConfigAndError()
    {
        $topic = 'test-topic3';
        $message = 'Test message';
        $key = 'test';

        $config = [
            'metadata.broker.list' => 'localhost:9093', //non functional host
            'compression.codec' => 'snappy',
            'message.timeout.ms' => '5000',
            'client.id' => 'php-producer',
        ];

        $this->kafkaProducer = new KafkaProducer($config);

        $this->kafkaProducer->produce($topic, $message, $key);

        $this->expectOutputString('Message FAILED (-192, Local: Message timed out) to send with payload => Test message');

    }
}
