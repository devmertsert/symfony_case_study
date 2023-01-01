<?php

namespace App\Controller;

use App\Entity\Employee;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/employee')]
class EmployeeController extends AbstractController
{
    #[Route('/create', methods: ['POST'], name: 'create_employee')]
    public function create(ManagerRegistry $doctrine, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        
        $entityManager = $doctrine->getManager();
        $employee = new Employee();

        if (!empty($parameters['ad'])) $employee->setAd($parameters['ad']);
        if (!empty($parameters['soyad'])) $employee->setSoyad($parameters['soyad']);
        if (!empty($parameters['ise_giris_tarihi'])) $employee->setIseGirisTarihi(new DateTime($parameters['ise_giris_tarihi']));
        if (!empty($parameters['isten_cikis_tarihi'])) $employee->setIstenCikisTarihi(new DateTime($parameters['isten_cikis_tarihi']));
        if (!empty($parameters['sgk_sicil_no'])) $employee->setSgkSicilNo($parameters['sgk_sicil_no']);
        if (!empty($parameters['tc_kimlik_no'])) $employee->setTcKimlikNo($parameters['tc_kimlik_no']);

        $errors = $validator->validate($employee);

        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $entityManager->persist($employee);
        $entityManager->flush();

        return $this->json([
            'status' => TRUE,
            'message' => 'Personel eklendi',
            'personel' => [
                'ad' => $parameters['ad'],
                'soyad' => $parameters['soyad']
            ]
        ], 201);
    }

    #[Route('/{id}/update', methods: ['POST'], name: 'update_employee')]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $employee = $entityManager->getRepository(Employee::class)->find($id);

        if (!$employee) return $this->json([
            "status" => FALSE,
            "errorMessage" => "Bu id ile eşleşen personel bulunamadı"
        ], 400);

        if (!empty($parameters['ad'])) $employee->setAd($parameters['ad']);
        if (!empty($parameters['soyad'])) $employee->setSoyad($parameters['soyad']);
        if (!empty($parameters['ise_giris_tarihi'])) $employee->setIseGirisTarihi(new DateTime($parameters['ise_giris_tarihi']));
        if (!empty($parameters['isten_cikis_tarihi'])) $employee->setIstenCikisTarihi(new DateTime($parameters['isten_cikis_tarihi']));
        if (!empty($parameters['sgk_sicil_no'])) $employee->setSgkSicilNo($parameters['sgk_sicil_no']);
        if (!empty($parameters['tc_kimlik_no'])) $employee->setTcKimlikNo($parameters['tc_kimlik_no']);
        
        $entityManager->flush();

        return $this->json([
            'status' => TRUE,
            'message' => $id.' id ile eşleşen personel başarıyla güncellendi'
        ]);
    }

    #[Route('/{id}/delete', methods: ['POST'], name: 'delete_employee')]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $employee = $entityManager->getRepository(Employee::class)->find($id);
        if (!$employee) return $this->json([
            "status" => FALSE,
            "errorMessage" => "Bu id ile eşleşen personel bulunamadı"
        ], 400);

        $entityManager->remove($employee);
        $entityManager->flush();

        return $this->json([
            'status' => TRUE,
            'message' => $id.' ile eşleşen personel silindi'
        ]);
    }
}