<?php
// src/Controllers/CompanyController.php

namespace App\Controllers;

use App\Helper;
use App\Company;

class CompanyController
{
    private $db;
    private $helper;

    public function __construct($db)
    {
        $this->db = $db;
        $this->helper = new Helper(); // Create an instance of the Helper class
    }

    public function createCompany($data)
    {
        // Validation and process the company data
        $company = new Company($this->db);
        $result = $company->createCompany($data['name'], $data['address'], $data['domain']);

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Company created successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to create company'], 500);
    }

    public function listCompanies()
    {
        $company = new Company($this->db);
        $companies = $company->listCompanies();

        if (!empty($companies)) {
            $this->helper->jsonResponse($companies);
            return;
        }

        $this->helper->jsonResponse(['message' => 'No companies found'], 404);
    }

    public function updateCompany($companyId, $data)
    {
        
        $company = new Company($this->db);
        $result = $company->updateCompany($companyId, $data['name'], $data['address'], $data['domain']);

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Company updated successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to update company'], 500);
    }
}
?>