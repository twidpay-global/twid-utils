# Twid Utils
This PHP library provides a convenient way to produce messages to Kafka topics using the RdKafka PHP extension.

## Installation

1. **Requirements**:
    - RdKafka PHP extension ([Installation Instructions](https://github.com/arnaud-lb/php-rdkafka#installation))

2. **Installation via Composer**:

   You can install the library via Composer. Run the following command in your terminal:

   ```bash
   composer require twidpay/utils
   ```
3. **Usage**:
    
    ```php
    $config = [
        'metadata.broker.list' => 'localhost:9092',
        'compression.codec' => 'snappy',
        'security.protocol' => 'ssl',
        //other kafka configuration
    ];
   
    $this->kafkaProducer = new KafkaProducer($config);

   //key is optional
    $this->kafkaProducer->produce($topic, $message, $key);
   ```
