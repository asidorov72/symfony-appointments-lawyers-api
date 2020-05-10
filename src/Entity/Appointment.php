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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $paymentStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $appointmentDatetime;

    /**
     * @ORM\Column(type="integer")
     */
    private $durationMins;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $appointmentTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $appointmentDesc;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $appointmentType;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(?string $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

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

    public function getAppointmentDatetime(): ?\DateTimeInterface
    {
        return $this->appointmentDatetime;
    }

    public function setAppointmentDatetime(\DateTimeInterface $appointmentDatetime): self
    {
        $this->appointmentDatetime = $appointmentDatetime;

        return $this;
    }

    public function getDurationMins(): ?int
    {
        return $this->durationMins;
    }

    public function setDurationMins(int $durationMins): self
    {
        $this->durationMins = $durationMins;

        return $this;
    }

    public function getAppointmentTitle(): ?string
    {
        return $this->appointmentTitle;
    }

    public function setAppointmentTitle(?string $appointmentTitle): self
    {
        $this->appointmentTitle = $appointmentTitle;

        return $this;
    }

    public function getAppointmentDesc(): ?string
    {
        return $this->appointmentDesc;
    }

    public function setAppointmentDesc(?string $appointmentDesc): self
    {
        $this->appointmentDesc = $appointmentDesc;

        return $this;
    }

    public function getAppointmentType(): ?string
    {
        return $this->appointmentType;
    }

    public function setAppointmentType(?string $appointmentType): self
    {
        $this->appointmentType = $appointmentType;

        return $this;
    }
}
