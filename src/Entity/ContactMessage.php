<?php

namespace App\Entity;

use App\Repository\ContactMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactMessageRepository::class)
 */
class ContactMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $writer_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $writer_email;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $message_text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWriterName(): ?string
    {
        return $this->writer_name;
    }

    public function setWriterName(string $writer_name): self
    {
        $this->writer_name = $writer_name;

        return $this;
    }

    public function getWriterEmail(): ?string
    {
        return $this->writer_email;
    }

    public function setWriterEmail(string $writer_email): self
    {
        $this->writer_email = $writer_email;

        return $this;
    }

    public function getMessageText(): ?string
    {
        return $this->message_text;
    }

    public function setMessageText(string $message_text): self
    {
        $this->message_text = $message_text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function isEverythingSet() {
        return isset($this->writer_name) && isset($this->writer_email) && isset($this->message_text);
    }
}
