<?php

namespace App\Controller;

use App\Entity\Permit;
use App\Entity\Employee;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/permit')]
class PermitController extends AbstractController
{
    #[Route('/create', methods: ['POST'], name: 'create_permit')]
    public function create(ManagerRegistry $doctrine, ValidatorInterface $validator, Request $request): JsonResponse
    {
        try {
            $parameters = json_decode($request->getContent(), true);
            
            $entityManager = $doctrine->getManager();
            $permit = new Permit();

            $employee = $entityManager->getRepository(Employee::class)->find($parameters['employee_id']);

            if (!$employee) return $this->json([
                "status" => FALSE,
                "errorMessage" => "Bu id ile eşleşen personel bulunamadı"
            ], 400);

            $permit->setIzinBaslangicTarihi(new DateTime($parameters['izin_baslangic_tarihi']));
            $permit->setIzinBitisTarihi(new DateTime($parameters['izin_bitis_tarihi']));
            $permit->setEmployeeId($employee);

            $entityManager->persist($permit);
            $entityManager->flush();

            return $this->json([
                'status' => TRUE,
                'message' => 'Yıllık izin eklendi',
                'yillik_izin' => [
                    'izin_baslangic_tarihi' => $parameters['izin_baslangic_tarihi'],
                    'izin_bitis_tarihi' => $parameters['izin_bitis_tarihi']
                ]
            ], 201);
        } catch (\Throwable $th) {
            return $this->json([
                "status" => FALSE,
                "message" => $th->getMessage(),
                "error" => $th
            ], 500);
        }
    }

    #[Route('/{id}/update', methods: ['POST'], name: 'update_permit')]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $permit = $entityManager->getRepository(Permit::class)->find($id);

        if (!$permit) return $this->json([
            "status" => FALSE,
            "errorMessage" => "Bu id ile eşleşen personel izni bulunamadı"
        ], 400);

        if (!empty($parameters['izin_baslangic_tarihi'])) $permit->setIzinBaslangicTarihi(new DateTime($parameters['izin_baslangic_tarihi']));
        if (!empty($parameters['izin_bitis_tarihi'])) $permit->setIzinBitisTarihi(new DateTime($parameters['izin_bitis_tarihi']));
        
        $entityManager->flush();

        return $this->json([
            'status' => TRUE,
            'message' => $id.' id ile eşleşen personel izni başarıyla güncellendi'
        ]);
    }

    #[Route('/{id}/delete', methods: ['POST'], name: 'delete_permit')]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $permit = $entityManager->getRepository(Permit::class)->find($id);
        if (!$permit) return $this->json([
            "status" => FALSE,
            "errorMessage" => "Bu id ile eşleşen personel izni bulunamadı"
        ], 400);

        $entityManager->remove($permit);
        $entityManager->flush();

        return $this->json([
            'status' => TRUE,
            'message' => $id.' ile eşleşen personel silindi'
        ]);
    }

    #[Route('/search', methods: ['GET'], name: 'find_permits')]
    public function find(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        try {
            $fullname = $request->query->get('fullname') ?? NULL;
            $izin_baslangic_tarihi = $request->query->get('izin_baslangic_tarihi') ?? NULL;
            $izin_bitis_tarihi = $request->query->get('izin_bitis_tarihi') ?? NULL;
            
            $entityManager = $doctrine->getManager();

            $searchResult = $entityManager->getRepository(Permit::class)->findByFilter($fullname, $izin_baslangic_tarihi, $izin_bitis_tarihi);

            return $this->json([
                "status" => TRUE,
                "permits" => $searchResult
            ], 400);
        } catch (\Throwable $th) {
            return $this->json([
                "status" => FALSE,
                "message" => $th->getMessage(),
                "error" => $th
            ], 500);
        }
    }
}