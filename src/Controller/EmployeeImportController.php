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
        // required due to line-break issues running this on a windows-environment
        $uploadedFile = $request->getContent();

        $errorEntries = [];
        $cacheCounter = 0;
        $inserts = 0;
        $updates = 0;
        $totalRows = 0;
        if (!empty($uploadedFile)) {
            $csv = Reader::createFromString($uploadedFile);

            // Assuming the first row contains headers
            $csv->setHeaderOffset(0);

            // Iterate through each row
            foreach ($csv->getRecords() as $record) {
                $totalRows++;
                try {
                    $existingEmployee = $this->em->getRepository(Employee::class)->find($record['Emp ID']);
                    $employee = $this->validationService->parseAndValidate($record, $existingEmployee);
                    if ($employee) {
                        if ($employee->getId() === 0) {
                            // if "Emp ID" could not be parsed to an integer, don´t import the employee
                            $errorEntries[] = $totalRows;
                            continue;
                        }
                        $this->em->persist($employee);
                        $existingEmployee ? $updates++ : $inserts++;

                        $cacheCounter++;
                        if ($cacheCounter == 1000) {
                            // to avoid cache problems in large csv-files flush database in between every 1000 imports
                            $this->em->flush();
                            $cacheCounter = 0;
                            $this->em->clear();
                        }
                    } else {
                        $errorEntries[] = $totalRows;
                    }
                } catch (Exception $e) {
                    return $this->json(['msg' => 'error when parsing employee with id ' . $record['Emp ID']], 400);
                }
            }
            $this->em->flush();
        }
        if (sizeof($errorEntries) === 0){
            return $this->json(['msg' => 'Successfully imported employee data, inserting ' . $inserts .' employees and updating ' . $updates]);
        } else {
            return $this->json((['msg' => 'successfully imported employee data, skipped some rows due to errors when importing. You can find a list of rows leading to errors attached',
                'errors' => json_encode($errorEntries)]));
        }
    }
}
