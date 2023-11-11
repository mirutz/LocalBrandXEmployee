<?php

namespace App\Service;

use App\Entity\Employee;
use DateTime;
use ValueError;

class EmployeeDataValidationService
{

    private const DATE_FORMAT = 'm/d/Y';
    private const TIME_FORMAT = 'h:i:s A';

    /**
     * @param array $data The employee-data, given as an array with strings as keys
     * @param Employee|null $existingEmployee If given, the employee will be updated instead of creating a new one
     * @return Employee|false Employee if a new employee was created or an existing one was updated
     * Returns false in case any of the required data is not set. Required fields in $data are:
     * [
     *  "Emp ID", "Name Prefix", "First Name", "Middle Initial", "Last Name", "Gender",
     *  "E Mail", "Date of Birth", "Time of Birth", "Age in Yrs.", "Date of Joining",
     *  "Age in Company (Years)", "Phone No.", "Place Name",
     *  "County", "City", "Zip", "Region", "User Name"
     * ]
     *
     */
    public function parseAndValidate(array $data, ?Employee $existingEmployee): Employee|false
    {
        try {
            if (isset(
                $data['Emp ID'],
                $data['Name Prefix'],
                $data['First Name'],
                $data['Middle Initial'],
                $data['Last Name'],
                $data['Gender'],
                $data['E Mail'],
                $data['Date of Birth'],
                $data['Time of Birth'],
                $data['Age in Yrs.'],
                $data['Date of Joining'],
                $data['Age in Company (Years)'],
                $data['Phone No. '],
                $data['Place Name'],
                $data['County'],
                $data['City'],
                $data['Zip'],
                $data['Region'],
                $data['User Name'])
            ) {
                if (!$existingEmployee) {
                    $employee = new Employee();
                } else {
                    $employee = $existingEmployee;
                }
                $employee->setId(intval($data['Emp ID']));
                $employee->setNamePrefix($data['Name Prefix']);
                $employee->setFirstName($data['First Name']);
                $employee->setMiddleInitial($data['Middle Initial']);
                $employee->setLastName($data['Last Name']);
                $employee->setGender($data['Gender']);
                $employee->setEmail($data['E Mail']);
                $dateOfBirth = DateTime::createFromFormat(self::DATE_FORMAT, $data['Date of Birth']);
                $timeOfBirth = DateTime::createFromFormat(self::TIME_FORMAT, $data['Time of Birth']);
                $dateOfJoin = DateTime::createFromFormat(self::DATE_FORMAT, $data['Date of Joining']);
                $employee->setDateOfBirth($dateOfBirth ?: null);
                $employee->setTimeOfBirth($timeOfBirth ?: null);
                $employee->setAgeInYrs(floatval($data['Age in Yrs.']));
                $employee->setDateOfJoining($dateOfJoin ?: null);
                $employee->setAgeInCompany(floatval($data['Age in Company (Years)']));
                $employee->setPhoneNumber($data['Phone No. ']);
                $employee->setPlaceName($data['Place Name']);
                $employee->setCounty($data['County']);
                $employee->setCity($data['City']);
                $employee->setZipCode($data['Zip']);
                $employee->setRegion($data['Region']);
                $employee->setUserName($data['User Name']);
                return $employee;
            }
        } catch (ValueError) {
            return false;
        }

        return false;
    }

}