<?php

namespace App\Entity;

use App\Repository\PermitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermitRepository::class)]
class Permit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'permits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $izin_baslangic_tarihi = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $izin_bitis_tarihi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?Employee
    {
        return $this->employee_id;
    }

    public function setEmployeeId(?Employee $employee_id): self
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    public function getIzinBaslangicTarihi(): ?\DateTimeInterface
    {
        return $this->izin_baslangic_tarihi;
    }

    public function setIzinBaslangicTarihi(\DateTimeInterface $izin_baslangic_tarihi): self
    {
        $this->izin_baslangic_tarihi = $izin_baslangic_tarihi;

        return $this;
    }

    public function getIzinBitisTarihi(): ?\DateTimeInterface
    {
        return $this->izin_bitis_tarihi;
    }

    public function setIzinBitisTarihi(\DateTimeInterface $izin_bitis_tarihi): self
    {
        $this->izin_bitis_tarihi = $izin_bitis_tarihi;

        return $this;
    }
}
