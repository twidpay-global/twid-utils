# Twid Utils v3.0.0
This PHP library provides utility classes for Twid applications. It's compatible with PHP 8.2+ and Laravel 12.

## Breaking Changes in v3.0.0
- Removed Kafka-related functionality
- Updated to support Laravel 12
- Upgraded to twidpay/twid-logger 3.0
- Requires PHP 8.2 or higher
- Improved type safety with PHP 8.4 support

## Installation

1. **Requirements**:
    - PHP 8.2 or higher
    - Laravel 12
    - twidpay/twid-logger 3.0

2. **Installation via Composer**:

   You can install the library via Composer. Run the following command in your terminal:

   ```bash
   composer require twidpay/utils
   ```

3. **Usage**:
   - The library includes utilities for handling PII data:

    ```php
   use Utils\PiiData\CustomerDataDTO;
 
    $data = [
        'id' => 1,
        'mobileNumber' => '1234567890',
        'firstname' => 'John',
        'middlename' => 'Doe',
        'lastname' => 'Smith',
        'email' => 'john.doe@example.com',
        'dob' => '1990-01-01',
        'hashedMobileNumber' => 'hash123'
    ];
   
    $customer = new CustomerDataDTO($data);
   ```
