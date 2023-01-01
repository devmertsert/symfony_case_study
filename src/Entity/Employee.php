<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ad = null;

    #[ORM\Column(length: 255)]
    private ?string $soyad = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $ise_giris_tarihi = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $isten_cikis_tarihi = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private ?string $sgk_sicil_no = null;

    #[ORM\Column(type: Types::BIGINT, unique: true)]
    private ?int $tc_kimlik_no = null;

    #[ORM\OneToMany(mappedBy: 'employee_id', targetEntity: Permit::class, orphanRemoval: true)]
    private Collection $permits;

    public function __construct()
    {
        $this->permits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAd(): ?string
    {
        return $this->ad;
    }

    public function setAd(string $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getSoyad(): ?string
    {
        return $this->soyad;
    }

    public function setSoyad(string $soyad): self
    {
        $this->soyad = $soyad;

        return $this;
    }

    public function getIseGirisTarihi(): ?\DateTimeInterface
    {
        return $this->ise_giris_tarihi;
    }

    public function setIseGirisTarihi(\DateTimeInterface $ise_giris_tarihi): self
    {
        $this->ise_giris_tarihi = $ise_giris_tarihi;

        return $this;
    }

    public function getIstenCikisTarihi(): ?\DateTimeInterface
    {
        return $this->isten_cikis_tarihi;
    }

    public function setIstenCikisTarihi(?\DateTimeInterface $isten_cikis_tarihi): self
    {
        $this->isten_cikis_tarihi = $isten_cikis_tarihi;

        return $this;
    }

    public function getSgkSicilNo(): ?string
    {
        return $this->sgk_sicil_no;
    }

    public function setSgkSicilNo(string $sgk_sicil_no): self
    {
        $this->sgk_sicil_no = $sgk_sicil_no;

        return $this;
    }

    public function getTcKimlikNo(): ?int
    {
        return $this->tc_kimlik_no;
    }

    public function setTcKimlikNo(int $tc_kimlik_no): self
    {
        $this->tc_kimlik_no = $tc_kimlik_no;

        return $this;
    }

    /**
     * @return Collection<int, Permit>
     */
    public function getPermits(): Collection
    {
        return $this->permits;
    }

    public function addPermit(Permit $permit): self
    {
        if (!$this->permits->contains($permit)) {
            $this->permits->add($permit);
            $permit->setEmployeeId($this);
        }

        return $this;
    }

    public function removePermit(Permit $permit): self
    {
        if ($this->permits->removeElement($permit)) {
            // set the owning side to null (unless already changed)
            if ($permit->getEmployeeId() === $this) {
                $permit->setEmployeeId(null);
            }
        }

        return $this;
    }
}
