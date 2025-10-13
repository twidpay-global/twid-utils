<?php 

use PHPUnit\Framework\TestCase;
use Utils\PiiData\CustomerDataDTO;

class CustomerPIIDataDTOTest extends TestCase
{
    public function testGettersAndSetters()
    {
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

        $dto = new CustomerDataDTO($data);

        $this->assertEquals($data['id'], $dto->getId());
        $this->assertEquals($data['mobileNumber'], $dto->getMobileNumber());
        $this->assertEquals($data['firstname'], $dto->getFirstname());
        $this->assertEquals($data['middlename'], $dto->getMiddlename());
        $this->assertEquals($data['lastname'], $dto->getLastname());
        $this->assertEquals($data['email'], $dto->getEmail());
        $this->assertEquals($data['dob'], $dto->getDob());
        $this->assertEquals($data['hashedMobileNumber'], $dto->getHashedMobileNumber());

        $newData = [
            'id' => 2,
            'mobileNumber' => '9876543210',
            'firstname' => 'Jane',
            'middlename' => 'Smith',
            'lastname' => 'Doe',
            'email' => 'jane.smith@example.com',
            'dob' => '1995-02-02',
            'hashedMobileNumber' => 'hash456'
        ];

        $dto->setId($newData['id']);
        $dto->setMobileNumber($newData['mobileNumber']);
        $dto->setFirstname($newData['firstname']);
        $dto->setMiddlename($newData['middlename']);
        $dto->setLastname($newData['lastname']);
        $dto->setEmail($newData['email']);
        $dto->setDob($newData['dob']);
        $dto->setHashedMobileNumber($newData['hashedMobileNumber']);

        $this->assertEquals($newData['id'], $dto->getId());
        $this->assertEquals($newData['mobileNumber'], $dto->getMobileNumber());
        $this->assertEquals($newData['firstname'], $dto->getFirstname());
        $this->assertEquals($newData['middlename'], $dto->getMiddlename());
        $this->assertEquals($newData['lastname'], $dto->getLastname());
        $this->assertEquals($newData['email'], $dto->getEmail());
        $this->assertEquals($newData['dob'], $dto->getDob());
        $this->assertEquals($newData['hashedMobileNumber'], $dto->getHashedMobileNumber());
    }
}