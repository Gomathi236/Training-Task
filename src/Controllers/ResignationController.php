<?php
// src/Controllers/ResignationController.php

namespace App\Controllers;

use App\Helper;
use App\Resignation;

class ResignationController
{
    private $db;
    private $helper;

    public function __construct($db)
    {
        $this->db = $db;
        $this->helper = new Helper(); // Create an instance of the Helper class
    }

    public function applyResignation($data)
    {
        // Validation and process the resignation data
        $resignation = new Resignation($this->db);
        $result = $resignation->applyResignation(
            $data['employee_id'],
            $data['company_id'],
            $data['status'],
            $data['date_requested'],
            $data['reason']
        );

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Resignation applied successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to apply resignation'], 500);
    }

    public function listResignations()
    {
        $resignation = new Resignation($this->db);
        $resignations = $resignation->listResignations();

        if (!empty($resignations)) {
            $this->helper->jsonResponse($resignations);
            return;
        }

        $this->helper->jsonResponse(['message' => 'No resignations found'], 404);
    }

}
?>