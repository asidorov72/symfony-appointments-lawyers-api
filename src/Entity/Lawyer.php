<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LawyerRepository")
 *     @ORM\Table(
 *     name="Lawyer",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"email"})}
 * )
 * @UniqueEntity(
 *      fields={"email"},
 *      message="Email already exists in database."
 * )
 */
class Lawyer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="text")
     */
    private $postalAddress;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $country;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lawyerLicenceNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $lawyerLicenseIssueDate;

    /**
     * @ORM\Column(type="date")
     */
    private $lawyerLicenseExpireDate;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lawyerLicenseName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lawyerDegree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfLawyer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPostalAddress(): ?string
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(string $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getLawyerLicenceNumber(): ?string
    {
        return $this->lawyerLicenceNumber;
    }

    public function setLawyerLicenceNumber(string $lawyerLicenceNumber): self
    {
        $this->lawyerLicenceNumber = $lawyerLicenceNumber;

        return $this;
    }

    public function getLawyerLicenseIssueDate(): ?\DateTimeInterface
    {
        return $this->lawyerLicenseIssueDate;
    }

    public function setLawyerLicenseIssueDate(\DateTimeInterface $lawyerLicenseIssueDate): self
    {
        $this->lawyerLicenseIssueDate = $lawyerLicenseIssueDate;

        return $this;
    }

    public function getLawyerLicenseExpireDate(): ?\DateTimeInterface
    {
        return $this->lawyerLicenseExpireDate;
    }

    public function setLawyerLicenseExpireDate(\DateTimeInterface $lawyerLicenseExpireDate): self
    {
        $this->lawyerLicenseExpireDate = $lawyerLicenseExpireDate;

        return $this;
    }

    public function getLawyerLicenseName(): ?string
    {
        return $this->lawyerLicenseName;
    }

    public function setLawyerLicenseName(?string $lawyerLicenseName): self
    {
        $this->lawyerLicenseName = $lawyerLicenseName;

        return $this;
    }

    public function getLawyerDegree(): ?string
    {
        return $this->lawyerDegree;
    }

    public function setLawyerDegree(string $lawyerDegree): self
    {
        $this->lawyerDegree = $lawyerDegree;

        return $this;
    }

    public function getTypeOfLawyer(): ?string
    {
        return $this->typeOfLawyer;
    }

    public function setTypeOfLawyer(string $typeOfLawyer): self
    {
        $this->typeOfLawyer = $typeOfLawyer;

        return $this;
    }
}
