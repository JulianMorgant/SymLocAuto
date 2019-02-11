<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $account;

    /**
     * @ORM\Column(type="string", length=20)
     */


    private $psw;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifyAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consumer", mappedBy="userId", orphanRemoval=true)
     */
    private $consumers;

    public function __construct()
    {
        $this->consumers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getPsw(): ?string
    {
        return $this->psw;
    }

    public function setPsw(string $psw): self
    {
        $this->psw = $psw;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getModifyAt(): ?\DateTimeInterface
    {
        return $this->modifyAt;
    }

    public function setModifyAt(\DateTimeInterface $modifyAt): self
    {
        $this->modifyAt = $modifyAt;

        return $this;
    }

    /**
     * @return Collection|Consumer[]
     */
    public function getConsumers(): Collection
    {
        return $this->consumers;
    }

    public function addConsumer(Consumer $consumer): self
    {
        if (!$this->consumers->contains($consumer)) {
            $this->consumers[] = $consumer;
            $consumer->setUserId($this);
        }

        return $this;
    }

    public function removeConsumer(Consumer $consumer): self
    {
        if ($this->consumers->contains($consumer)) {
            $this->consumers->removeElement($consumer);
            // set the owning side to null (unless already changed)
            if ($consumer->getUserId() === $this) {
                $consumer->setUserId(null);
            }
        }

        return $this;
    }
}
