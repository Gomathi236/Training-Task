<?php
// api/src/Employee.php

namespace App;
use PDOException;
use PDO;

class Employee
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createEmployee($name, $email, $phone, $address, $dateOfBirth, $onboardDate, $salary, $qualifications, $numOfYearsExp)
    {
        // Generate a unique ID with a length of 13 characters
        $employeeId = substr(uniqid(), -13);
    
        // Set default values for company_id, department_id, and job_position_id
        $companyId = 1; // Assuming you want to set a default company_id, change this value accordingly
        $departmentId = 1; // Assuming you want to set a default department_id, change this value accordingly
        $jobPositionId = 1; // Assuming you want to set a default job_position_id, change this value accordingly
    
        $sql = "INSERT INTO employees (employee_id, company_id, department_id, job_position_id, name, email, phone, address, date_of_birth, onboard_date, salary, qualifications, number_of_year_experiences, created_at, updated_at, is_deleted) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)";
    
        try {
            $stmt = $this->conn->prepare($sql);
    
            // Set is_deleted to 0 (false) explicitly
            $isDeleted = 0;
    
            // Bind parameters and execute the statement
            $stmt->execute([$employeeId, $companyId, $departmentId, $jobPositionId, $name, $email, $phone, $address, $dateOfBirth, $onboardDate, $salary, $qualifications, $numOfYearsExp, $isDeleted]);
    
            return true;
        } catch (PDOException $e) {
            // You might want to handle the exception here if needed
            echo "Failed to create employee. Error: " . $e->getMessage();
            return false;
        }
    }
    

    

    public function listEmployees()
{
    $sql = "SELECT * FROM employees";
    $result = $this->conn->query($sql);

    if ($result->rowCount() > 0) {
        $employees = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $employees[] = $row;
        }
        return $employees;
    }

    return "No employees found!";
}

    
public function getEmployeeById($employeeId)
{
    $sql = "SELECT * FROM employees WHERE id = :employeeId";
    $stmt = $this->conn->prepare($sql);

    // Bind the named parameter and execute the statement
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        return $result[0]; // Return the first row
    }
    
    return null; // No employee found
}



    public function updateEmployee($employeeId, $name, $email, $phone, $address, $dateOfBirth, $onboardDate, $salary, $qualifications, $numOfYearsExp)
    {
        $sql = "UPDATE employees SET name = :name, email = :email, phone = :phone, address = :address, date_of_birth = :date_of_birth, onboard_date = :onboard_date, salary = :salary, qualifications = :qualifications, number_of_year_experiences = :number_of_year_experiences, updated_at = NOW() WHERE id = :employee_id";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_birth', $dateOfBirth, PDO::PARAM_STR);
        $stmt->bindValue(':onboard_date', $onboardDate, PDO::PARAM_STR);
        $stmt->bindValue(':salary', $salary, PDO::PARAM_INT);
        $stmt->bindValue(':qualifications', $qualifications, PDO::PARAM_STR);
        $stmt->bindValue(':number_of_year_experiences', $numOfYearsExp, PDO::PARAM_INT);
        $stmt->bindValue(':employee_id', $employeeId, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }

   

}
?>