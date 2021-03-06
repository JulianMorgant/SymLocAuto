<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(
     *     min = "4",
     *     max = "20",
     *     minMessage = "4 caractères minimum",
     *     maxMessage = "20 caractères max"
     *     )
     * @Assert\NotBlank
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Email(message = " '{{ value }}' n'est pas un mail valide." )
     * @Assert\Length(
     *     min = "4",
     *     max = "50",
     *     minMessage = "4 caractères minimum",
     *     maxMessage = "50 caractères max"
     *     )
     * @Assert\NotBlank
     */

    private $mail;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Choice(
     *     choices = { "admin", "user" },
     *     message = "Choose a valid account type (admin or user)."
     * )
     * @Assert\NotBlank
     *
     */
    private $account;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(
     *     min = "4",
     *     max = "50",
     *     minMessage = "4 caractères minimum",
     *     maxMessage = "20 caractères max"
     *     )
     * @Assert\NotBlank
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="userId", orphanRemoval=true)
     */
    private $annonces;

    public function __construct()
    {
        $this->consumers = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setUserId($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getUserId() === $annonce) {
                $annonce->setUserId(null);
            }
        }

        return $this;
    }
}
