<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Service\EmployeeDataValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeImportController extends AbstractController
{
    private EntityManagerInterface $em;
    private EmployeeDataValidationService $validationService;

    public function __construct(EntityManagerInterface $entityManager, EmployeeDataValidationService $employeeDataValidationService)
    {
        $this->validationService = $employeeDataValidationService;
        $this->em = $entityManager;
    }

    public function __invoke(Request $request): Response
    {
        $uploadedFile = str_replace(["\n"], "\r\n", $request->getContent());

        $skippedEmployees = [];
        $errorEntries = [];
        $counter = 0;
        $inserts = 0;
        if (!empty($uploadedFile)) {
            $csv = Reader::createFromString($uploadedFile);

            // Assuming the first row contains headers
            $csv->setHeaderOffset(0);
            $updates = 0;
            // Iterate through each row
            foreach ($csv->getRecords() as $record) {
                try {
                    $existingEmployee = $this->em->getRepository(Employee::class)->find($record['Emp ID']);
                    $employee = $this->validationService->parseAndValidate($record, $existingEmployee);
                    if ($employee) {
                        if ($employee->getId() === 0) {
//                            $errorEntries[] = $employee;
                            continue;
                        }
                        $this->em->persist($employee);
                        $existingEmployee ? $updates++ : $inserts++;

                        $counter++;
                        if ($counter == 1000) {
                            // to avoid cache problems in large csv-files flush database in between every 1000 imports
                            $this->em->flush();
                            $counter = 0;
                            $this->em->clear();

                        }
                    } else {
                        $errorEntries[] = $record['Emp ID'];
                    }
                } catch (Exception $e) {
                    return $this->json(['msg' => 'error when parsing employee with id ' . $record['Emp ID']], 400);
                }
            }
            $this->em->flush();
        }
        if (sizeof($skippedEmployees) === 0 && sizeof($errorEntries) === 0){
            return $this->json(['msg' => 'Successfully imported employee data, inserting ' . $inserts .' employees and updating ' . $updates]);
        } else {
            return $this->json((['msg' => 'successfully imported employee data, skipped some rows due to duplicate or wrong employee-IDs',
                'duplicates' => json_encode($skippedEmployees),
                'errors' => json_encode($errorEntries)]));
        }
    }
}
