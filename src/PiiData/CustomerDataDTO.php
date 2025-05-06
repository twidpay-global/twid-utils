<?php

namespace Utils\PiiData;

class CustomerDataDTO
{
    private int $id;

    private string $mobileNumber;

    private string $firstname;

    private string $middlename;

    private string $lastname;

    private string $email;

    private string $dob;

    private string $hashedMobileNumber;

    public function __construct(array $fields)
    {
        $properties = ['id', 'mobileNumber', 'firstname', 'middlename', 'lastname', 'email', 'dob', 'hashedMobileNumber'];
        foreach ($fields as $key => $value) {
            if (in_array($key, $properties, true)) {
                $this->$key = $value;
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
    public function getFirstname(): string
    {
        return $this->firstname?? '';
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    // Getter and Setter for middleName
    public function getMiddlename(): string
    {
        return $this->middlename?? '';
    }

    public function setMiddlename(string $middlename): void
    {
        $this->middlename = $middlename;
    }

    // Getter and Setter for lastName
    public function getLastname(): string
    {
        return $this->lastname?? '';
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    // Getter and Setter for email
    public function getEmail(): string
    {
        return $this->email?? '';
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Getter and Setter for dob
    public function getDob(): string
    {
        return $this->dob?? '';
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

    public function isEmpty(): bool {
        return empty($this->id);
    }
}