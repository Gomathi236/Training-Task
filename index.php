<?php
// index.php

require_once 'vendor/autoload.php';
require_once 'src/database.php';
require_once 'src/Company.php';
require_once 'src/Employee.php';
require_once 'src/JobPosition.php';
require_once 'src/Resignation.php';


require_once 'vendor/autoload.php';
require_once 'src/database.php';

use App\Database;
use App\Company;
use App\Employee;
use App\JobPosition;
use App\Resignation;



$db = new Database();
$conn = $db->getConnection();
$db = new Database();
$conn = $db->getConnection();

//  root URL request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/') {
    echo "Welcome to the API!"; // Return a welcome message or any other default response
    exit;
}

//  /companies POST endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/companies') {
    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Create a new Company object and pass the database connection
    $company = new Company($conn);

    // Call the createCompany method with the provided data
    $result = $company->createCompany($data['name'], $data['address'], $data['domain']);

    // Check the result and display a message accordingly
    if ($result) {
        echo "Company created successfully!";
    } else {
        echo "Failed to create company!";
    }

    exit;
}


//  /companies GET endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/companies') {
    // List all companies
    $company = new Company($conn);
    $companies = $company->listCompanies();

    header('Content-Type: application/json');
    echo json_encode($companies);

    exit;
}

//  PUT /companies/{id} endpoint
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/companies\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $companyId = $matches[1];

    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required fields are present in the $data array
    $requiredFields = ['name', 'address', 'domain'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        // Return an error response indicating the missing fields
        echo "Failed to update company. Missing fields: " . implode(', ', $missingFields);
        exit;
    }

    // Extract individual properties from the $data array
    $name = $data['name'];
    $address = $data['address'];
    $domain = $data['domain'];

    // Create a new Company object and pass the database connection
    $company = new Company($conn);

    // Call the updateCompany method with the provided data
    $result = $company->updateCompany($companyId, $name, $address, $domain);

    // Check the result and display a message accordingly
    if ($result) {
        echo "Company updated successfully!";
    } else {
        echo "Failed to update company!";
    }

    exit;
}


// /employees POST endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/employees') {
    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required fields are present in the $data array
    $requiredFields = ['name', 'email', 'phone', 'address', 'date_of_birth', 'onboard_date', 'salary', 'qualifications', 'number_of_year_experiences'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        // Return an error response indicating the missing fields
        echo "Failed to create employee. Missing fields: " . implode(', ', $missingFields);
        exit;
    }

    // Extract individual properties from the $data array
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $address = $data['address'];
    $dateOfBirth = $data['date_of_birth'];
    $onboardDate = isset($data['onboard_date']) ? $data['onboard_date'] : null;
    $salary = $data['salary'];
    $qualifications = $data['qualifications'];
    $numOfYearsExp = isset($data['number_of_year_experiences']) ? $data['number_of_year_experiences'] : null;

    // Create a new Employee object and pass the database connection
    $employee = new Employee($conn);

    // Call the createEmployee method with the provided data
    $result = $employee->createEmployee(
        $name,
        $email,
        $phone,
        $address,
        $dateOfBirth,
        $onboardDate,
        $salary,
        $qualifications,
        $numOfYearsExp
    );

    // Check the result and display a message accordingly
    if ($result) {
        echo "Employee created successfully!";
    } else {
        echo "Failed to create employee!";
    }

    exit;
}



///employees GET endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/employees') {
    // List all employees
    $employee = new Employee($conn);
    $employees = $employee->listEmployees();

    if (!empty($employees)) {
        header('Content-Type: application/json');
        echo json_encode($employees);
    } else {
        echo "No employees found!";
    }

    exit;
}
// /employees PUT endpoint
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/employees\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $employeeId = $matches[1];
    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required fields are present in the $data array
    $requiredFields = ['name', 'email', 'phone', 'address', 'date_of_birth', 'onboard_date', 'salary', 'qualifications', 'number_of_year_experiences'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        // Return an error response indicating the missing fields
        echo "Failed to update employee. Missing fields: " . implode(', ', $missingFields);
        exit;
    }

    // Extract individual properties from the $data array
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $address = $data['address'];
    $dateOfBirth = $data['date_of_birth'];
    $onboardDate = isset($data['onboard_date']) ? $data['onboard_date'] : null;
    $salary = $data['salary'];
    $qualifications = $data['qualifications'];
    $numOfYearsExp = isset($data['number_of_year_experiences']) ? $data['number_of_year_experiences'] : null;

    // Create a new Employee object and pass the database connection
    $employee = new Employee($conn);

    // Call the updateEmployee method with the provided data
    $result = $employee->updateEmployee(
        $employeeId,
        $name,
        $email,
        $phone,
        $address,
        $dateOfBirth,
        $onboardDate,
        $salary,
        $qualifications,
        $numOfYearsExp
    );

    // Check the result and display a message accordingly
    if ($result) {
        echo "Employee updated successfully!";
    } else {
        echo "Failed to update employee!";
    }

    exit;
}
// GET request to retrieve an employee by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/\/employees\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $employeeId = intval($matches[1]);

    // Create a new Employee object and pass the database connection
    $employee = new Employee($conn);

    // Call the getEmployeeById method with the provided employee ID
    $employeeData = $employee->getEmployeeById($employeeId);

    if ($employeeData) {
        // Return the employee data as JSON response
        header('Content-Type: application/json');
        echo json_encode($employeeData);
    } else {
        echo "Employee not found!";
    }

    exit;
}


// /job_positions POST endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/job_positions') {
    // Create a new job position
    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required fields are present in the $data array
    $requiredFields = ['company_id', 'name', 'description', 'job_level'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        // Return an error response indicating the missing fields
        echo "Failed to create job position. Missing fields: " . implode(', ', $missingFields);
        exit;
    }

    // Extract individual properties from the $data array
    $companyId = $data['company_id'];
    $name = $data['name'];
    $description = $data['description'];
    $jobLevel = $data['job_level'];

    // Map job levels to integer values
    $jobLevels = [
        'Entry Level' => 1,
        'Intermediate' => 2,
        'Senior' => 3,
        // Add more job levels as needed
    ];

    // Check if the provided job level is valid
    if (!isset($jobLevels[$jobLevel])) {
        echo "Invalid job level: $jobLevel";
        exit;
    }

    // Get the corresponding integer value for the job level
    $mappedJobLevel = $jobLevels[$jobLevel];

    // Create a new JobPosition object and pass the database connection
    $jobPosition = new JobPosition($conn);

    // Call the createJobPosition method with the provided data
    $result = $jobPosition->createJobPosition($companyId, $name, $description, $mappedJobLevel);

    if ($result) {
        echo "Job position created successfully!";
    } else {
        echo "Failed to create job position!";
    }

    exit;
}




// /job_positions GET endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/job_positions') {
    $jobPosition = new JobPosition($conn);
    $jobPositions = $jobPosition->listJobPositions();

    if (!empty($jobPositions)) {
        header('Content-Type: application/json');
        echo json_encode($jobPositions);
    } else {
        echo "No job positions found!";
    }

    exit;
}
//  PUT request to update a resignation
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/resignations\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $resignationId = intval($matches[1]);

    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    $status = $data['status'];
    $dateRequested = $data['date_requested'];
    $reason = $data['reason'];

    // Create a new Resignation object and pass the database connection
    $resignation = new Resignation($conn);

    // Call the updateResignation method with the provided data
    $result = $resignation->updateResignation($resignationId, $status, $dateRequested, $reason);

    // Check the result and display a message accordingly
    if ($result) {
        echo "Resignation updated successfully!";
    } else {
        echo "Failed to update resignation!";
    }

    exit;
}


//  /resignations POST endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/resignations') {
    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required fields are present in the $data array
    $requiredFields = ['employee_id', 'company_id', 'status', 'date_requested', 'reason'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        // Return an error response indicating the missing fields
        echo "Failed to apply resignation. Missing fields: " . implode(', ', $missingFields);
        exit;
    }

    // Extract individual properties from the $data array
    $employeeId = $data['employee_id'];
    $companyId = $data['company_id'];
    $status = $data['status'];
    $dateRequested = $data['date_requested'];
    $reason = $data['reason'];

    // Create a new Resignation object and pass the database connection
    $resignation = new Resignation($conn);

    // Call the applyResignation method with the provided data
    $result = $resignation->applyResignation($employeeId, $companyId, $status, $dateRequested, $reason);

    // Check the result and display a message accordingly
    if ($result) {
        echo "Resignation applied successfully!";
    } else {
        echo "Failed to apply resignation!";
    }

    exit;
}
//  /resignations GET endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/resignations') {
    // List all resignations
    $resignation = new Resignation($conn);
    $resignations = $resignation->listResignations();

    if (!empty($resignations)) {
        header('Content-Type: application/json');
        echo json_encode($resignations);
    } else {
        echo "No resignations found!";
    }

    exit;
}
// PUT request to update a resignation
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/resignations\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $resignationId = intval($matches[1]);

    // Assuming that data is sent as JSON in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    $status = $data['status'];
    $dateRequested = $data['date_requested'];
    $reason = $data['reason'];

    // Create a new Resignation object and pass the database connection
    $resignation = new Resignation($conn);

    // Call the updateResignation method with the provided data
    $result = $resignation->updateResignation($resignationId, $status, $dateRequested, $reason);

    if ($result) {
        echo "Resignation updated successfully!";
    } else {
        echo "Failed to update resignation!";
    }

    exit;
}





http_response_code(404);
echo "404 Not Found";
exit;
?>
