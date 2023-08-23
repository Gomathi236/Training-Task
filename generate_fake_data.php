<?php
require 'vendor/autoload.php';
require_once 'src/Services/database.php';

use Faker\Factory;
use App\Services\Database;
use App\Controllers\CompanyController;
use App\Controllers\EmployeeController;
use App\Controllers\JobPositionController;
use App\Controllers\ResignationController;

$db = new Database();
$conn = $db->getConnection();

$companyController = new CompanyController($conn);
$employeeController = new EmployeeController($conn);
$jobPositionController = new JobPositionController($conn);
$resignationController = new ResignationController($conn);

// Create a Faker instance
$faker = Factory::create();

// Generate and insert fake companies
for ($i = 0; $i < 1000; $i++) {
    $companyData = [
        'name' => $faker->company,
        'address' => $faker->address,
        'domain' => $faker->domainName,
    ];

    $companyController->createCompany($companyData);
}

// Generate and insert fake employees
for ($i = 0; $i < 1000; $i++) {
    $employeeData = [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'date_of_birth' => $faker->date('Y-m-d'),
        'onboard_date' => $faker->date('Y-m-d'),
        'salary' => $faker->randomFloat(2, 30000, 100000),
        'qualifications' => $faker->sentence(3),
        'number_of_year_experiences' => $faker->numberBetween(0, 10),
    ];

    $employeeController->createEmployee($employeeData);
}

// Generate and insert fake job positions
for ($i = 0; $i < 1000; $i++) {
    $jobPositionData = [
        'company_id' => $faker->numberBetween(1, 20),
        'name' => $faker->jobTitle,
        'description' => $faker->paragraph,
        'job_level' => $faker->randomElement([1, 2, 3]), 
    ];

    $jobPositionController->createJobPosition($jobPositionData);
}


// Generate and insert fake resignations
for ($i = 0; $i < 1000; $i++) {
    $resignationData = [
        'employee_id' => $faker->numberBetween(1, 20),
        'company_id' => $faker->numberBetween(1, 20),
        'status' => $faker->randomElement(['Pending', 'Approved', 'Rejected']),
        'date_requested' => $faker->date('Y-m-d'),
        'reason' => $faker->sentence,
    ];

    $resignationController->applyResignation($resignationData);
}

?>