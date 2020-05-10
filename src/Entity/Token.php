<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uuidToken;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $citizenId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lawyerId;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUuidToken(): ?string
    {
        return $this->uuidToken;
    }

    public function setUuidToken(string $uuidToken): self
    {
        $this->uuidToken = $uuidToken;

        return $this;
    }

    public function getCitizenId(): ?int
    {
        return $this->citizenId;
    }

    public function setCitizenId(?int $citizenId): self
    {
        $this->citizenId = $citizenId;

        return $this;
    }

    public function getLawyerId(): ?int
    {
        return $this->lawyerId;
    }

    public function setLawyerId(?int $lawyerId): self
    {
        $this->lawyerId = $lawyerId;

        return $this;
    }
}
