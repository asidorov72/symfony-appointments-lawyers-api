<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentRepository")
 */
class Appointment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $lawyerId;

    /**
     * @ORM\Column(type="integer")
     */
    private $citizenId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $meetingType;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $meetingTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $meetingDescription;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $paymentStatus;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCitizenEmail(): ?string
    {
        return $this->citizenEmail;
    }

    public function setCitizenEmail(string $citizenEmail): self
    {
        $this->citizenEmail = $citizenEmail;

        return $this;
    }

    public function getLawyerId(): ?int
    {
        return $this->lawyerId;
    }

    public function setLawyerId(int $lawyerId): self
    {
        $this->lawyerId = $lawyerId;

        return $this;
    }

    public function getCitizenId(): ?int
    {
        return $this->citizenId;
    }

    public function setCitizenId(int $citizenId): self
    {
        $this->citizenId = $citizenId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMeetingType(): ?string
    {
        return $this->meetingType;
    }

    public function setMeetingType(string $meetingType): self
    {
        $this->meetingType = $meetingType;

        return $this;
    }

    public function getMeetingTitle(): ?string
    {
        return $this->meetingTitle;
    }

    public function setMeetingTitle(string $meetingTitle): self
    {
        $this->meetingTitle = $meetingTitle;

        return $this;
    }

    public function getMeetingDescription(): ?string
    {
        return $this->meetingDescription;
    }

    public function setMeetingDescription(?string $meetingDescription): self
    {
        $this->meetingDescription = $meetingDescription;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(?string $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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
}
