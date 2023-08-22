<?php
// index.php

require_once 'vendor/autoload.php';
require_once 'src/Services/database.php';

use App\Services\Database;
use App\Controllers\CompanyController;
use App\Controllers\EmployeeController;
use App\Controllers\JobPositionController;
use App\Controllers\ResignationController;

$db = new Database();
$conn = $db->getConnection();

// controller instances
$companyController = new CompanyController($conn);
$employeeController = new EmployeeController($conn);
$jobPositionController = new JobPositionController($conn);
$resignationController = new ResignationController($conn);

//  root URL request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/') {
    echo "Welcome to the API!";
    exit;
}

//  /companies endpoints
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/companies') {
    $data = json_decode(file_get_contents('php://input'), true);
    $companyController->createCompany($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/companies') {
    $companyController->listCompanies();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/companies\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $companyId = $matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    $companyController->updateCompany($companyId, $data);
    exit;
}

//  /employees endpoints
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/employees') {
    $data = json_decode(file_get_contents('php://input'), true);
    $employeeController->createEmployee($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/employees') {
    $employeeController->listEmployees();
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/employees\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $employeeId = $matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    $employeeController->updateEmployee($employeeId, $data);
    exit;
}



//  /job_positions endpoints
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/job_positions') {
    $data = json_decode(file_get_contents('php://input'), true);
    $jobPositionController->createJobPosition($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/job_positions') {
    $jobPositionController->listJobPositions();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/\/job_positions\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $jobPositionId = $matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    $jobPositionController->updateJobPosition($jobPositionId, $data);
    exit;
}

//  /resignations endpoints
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/resignations') {
    $data = json_decode(file_get_contents('php://input'), true);
    $resignationController->applyResignation($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/resignations') {
    $resignationController->listResignations();
    exit;
}



//  404 Not Found for any other endpoints
http_response_code(404);
echo "404 Not Found";
exit;
?>
