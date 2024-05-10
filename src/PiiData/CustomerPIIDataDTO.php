<?php

namespace Utils\PiiData;

class CustomerPIIDataDTO
{
    private int $id;

    private string $mobileNumber;

    private string $firstName;

    private string $middleName;

    private string $lastName;

    private string $email;

    private string $dob;

    private string $hashedMobileNumber;

    // Constructor to initialize properties with an associative array
    public function __construct(array $fields)
    {
        // Define expected properties
        $properties = ['id', 'mobileNumber', 'firstName', 'middleName', 'lastName', 'email', 'dob', 'hashedMobileNumber'];

        // Check if all provided keys are valid properties
        foreach ($fields as $key => $value) {
            if (!in_array($key, $properties, true)) {
                throw new InvalidArgumentException('Invalid field provided: ' . $key);
            }
            $this->$key = $value;
        }

        // Check if all required properties are set
        foreach ($properties as $property) {
            if (!isset($this->$property)) {
                throw new InvalidArgumentException('Missing required field: ' . $property);
            }
        }
    }

    // Getter and Setter for id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getter and Setter for mobileNumber
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    // Getter and Setter for firstName
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    // Getter and Setter for middleName
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    // Getter and Setter for lastName
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    // Getter and Setter for email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Getter and Setter for dob
    public function getDob(): string
    {
        return $this->dob;
    }

    public function setDob(string $dob): void
    {
        $this->dob = $dob;
    }

    // Getter and Setter for hashedMobileNumber
    public function getHashedMobileNumber(): string
    {
        return $this->hashedMobileNumber;
    }

    public function setHashedMobileNumber(string $hashedMobileNumber): void
    {
        $this->hashedMobileNumber = $hashedMobileNumber;
    }
}