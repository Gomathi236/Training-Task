<?php
// src/Controllers/EmployeeController.php

namespace App\Controllers;

use App\Helper;
use App\Employee;

class EmployeeController
{
    private $db;
    private $helper;

    public function __construct($db)
    {
        $this->db = $db;
        $this->helper = new Helper(); 
    }

    public function createEmployee($data)
    {
        // Validation and process the employee data
        $employee = new Employee($this->db);
        $result = $employee->createEmployee(
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['date_of_birth'],
            $data['onboard_date'],
            $data['salary'],
            $data['qualifications'],
            $data['number_of_year_experiences']
        );

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Employee created successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to create employee'], 500);
    }

    public function listEmployees()
    {
        $employee = new Employee($this->db);
        $employees = $employee->listEmployees();

        if (!empty($employees)) {
            $this->helper->jsonResponse($employees);
            return;
        }

        $this->helper->jsonResponse(['message' => 'No employees found'], 404);
    }

    public function updateEmployee($employeeId, $data)
    {
       
        $employee = new Employee($this->db);
        $result = $employee->updateEmployee(
            $employeeId,
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['date_of_birth'],
            $data['onboard_date'],
            $data['salary'],
            $data['qualifications'],
            $data['number_of_year_experiences']
        );

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Employee updated successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to update employee'], 500);
    }


}
?>