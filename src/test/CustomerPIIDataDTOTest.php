<?php 

use PHPUnit\Framework\TestCase;
use Utils\PiiData\CustomerPIIDataDTO;

class CustomerPIIDataDTOTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $data = [
            'id' => 1,
            'mobileNumber' => '1234567890',
            'firstName' => 'John',
            'middleName' => 'Doe',
            'lastName' => 'Smith',
            'email' => 'john.doe@example.com',
            'dob' => '1990-01-01',
            'hashedMobileNumber' => 'hash123'
        ];

        $dto = new CustomerPIIDataDTO($data);

        $this->assertEquals($data['id'], $dto->getId());
        $this->assertEquals($data['mobileNumber'], $dto->getMobileNumber());
        $this->assertEquals($data['firstName'], $dto->getFirstName());
        $this->assertEquals($data['middleName'], $dto->getMiddleName());
        $this->assertEquals($data['lastName'], $dto->getLastName());
        $this->assertEquals($data['email'], $dto->getEmail());
        $this->assertEquals($data['dob'], $dto->getDob());
        $this->assertEquals($data['hashedMobileNumber'], $dto->getHashedMobileNumber());

        $newData = [
            'id' => 2,
            'mobileNumber' => '9876543210',
            'firstName' => 'Jane',
            'middleName' => 'Smith',
            'lastName' => 'Doe',
            'email' => 'jane.smith@example.com',
            'dob' => '1995-02-02',
            'hashedMobileNumber' => 'hash456'
        ];

        $dto->setId($newData['id']);
        $dto->setMobileNumber($newData['mobileNumber']);
        $dto->setFirstName($newData['firstName']);
        $dto->setMiddleName($newData['middleName']);
        $dto->setLastName($newData['lastName']);
        $dto->setEmail($newData['email']);
        $dto->setDob($newData['dob']);
        $dto->setHashedMobileNumber($newData['hashedMobileNumber']);

        $this->assertEquals($newData['id'], $dto->getId());
        $this->assertEquals($newData['mobileNumber'], $dto->getMobileNumber());
        $this->assertEquals($newData['firstName'], $dto->getFirstName());
        $this->assertEquals($newData['middleName'], $dto->getMiddleName());
        $this->assertEquals($newData['lastName'], $dto->getLastName());
        $this->assertEquals($newData['email'], $dto->getEmail());
        $this->assertEquals($newData['dob'], $dto->getDob());
        $this->assertEquals($newData['hashedMobileNumber'], $dto->getHashedMobileNumber());
    }
}