<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\EmployeeImportController;
use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/employee/{id}', formats: 'json'),
        new GetCollection(uriTemplate: '/employee',),
        new Delete(uriTemplate: '/employee/{id}',),
        new Post(
            uriTemplate: '/employee',
            controller: EmployeeImportController::class
        )
    ],
    formats: ['json',  'csv' => ['text/csv']]
)]
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $userName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $namePrefix = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $middleInitial = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeOfBirth = null;

    #[ORM\Column(nullable: true)]
    private ?float $ageInYrs = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfJoining = null;

    #[ORM\Column]
    private ?float $ageInCompany = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $placeName = null;

    #[ORM\Column(length: 255)]
    private ?string $county = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): Employee
    {
        $this->id = $id;
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): Employee
    {
        $this->userName = $userName;
        return $this;
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function setNamePrefix(?string $namePrefix): Employee
    {
        $this->namePrefix = $namePrefix;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Employee
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getMiddleInitial(): ?string
    {
        return $this->middleInitial;
    }

    public function setMiddleInitial(?string $middleInitial): Employee
    {
        $this->middleInitial = $middleInitial;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Employee
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): Employee
    {
        $this->gender = $gender;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Employee
    {
        $this->email = $email;
        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): Employee
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getTimeOfBirth(): ?\DateTimeInterface
    {
        return $this->timeOfBirth;
    }

    public function setTimeOfBirth(?\DateTimeInterface $timeOfBirth): Employee
    {
        $this->timeOfBirth = $timeOfBirth;
        return $this;
    }

    public function getAgeInYrs(): ?float
    {
        return $this->ageInYrs;
    }

    public function setAgeInYrs(?float $ageInYrs): Employee
    {
        $this->ageInYrs = $ageInYrs;
        return $this;
    }

    public function getDateOfJoining(): ?\DateTimeInterface
    {
        return $this->dateOfJoining;
    }

    public function setDateOfJoining(?\DateTimeInterface $dateOfJoining): Employee
    {
        $this->dateOfJoining = $dateOfJoining;
        return $this;
    }

    public function getAgeInCompany(): ?float
    {
        return $this->ageInCompany;
    }

    public function setAgeInCompany(?float $ageInCompany): Employee
    {
        $this->ageInCompany = $ageInCompany;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): Employee
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getPlaceName(): ?string
    {
        return $this->placeName;
    }

    public function setPlaceName(?string $placeName): Employee
    {
        $this->placeName = $placeName;
        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): Employee
    {
        $this->county = $county;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Employee
    {
        $this->city = $city;
        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): Employee
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): Employee
    {
        $this->region = $region;
        return $this;
    }
}
