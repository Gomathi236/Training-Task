<?php
// src/Controllers/JobPositionController.php

namespace App\Controllers;

use App\Helper;
use App\JobPosition;

class JobPositionController
{
    private $db;
    private $helper;

    public function __construct($db)
    {
        $this->db = $db;
        $this->helper = new Helper(); // Create an instance of the Helper class
    }

    public function createJobPosition($data)
    {
        // Validation and process the job position data
        $jobPosition = new JobPosition($this->db);
        $result = $jobPosition->createJobPosition(
            $data['company_id'],
            $data['name'],
            $data['description'],
            $data['job_level']
        );

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Job position created successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to create job position'], 500);
    }

    public function listJobPositions()
    {
        $jobPosition = new JobPosition($this->db);
        $jobPositions = $jobPosition->listJobPositions();

        if (!empty($jobPositions)) {
            $this->helper->jsonResponse($jobPositions);
            return;
        }

        $this->helper->jsonResponse(['message' => 'No job positions found'], 404);
    }

    public function updateJobPosition($jobPositionId, $data)
    {
        $jobPosition = new JobPosition($this->db);
        $result = $jobPosition->updateJobPosition(
            $jobPositionId,
            $data['company_id'],
            $data['name'],
            $data['description'],
            $data['job_level']
        );

        if ($result) {
            $this->helper->jsonResponse(['message' => 'Job position updated successfully']);
            return;
        }

        $this->helper->jsonResponse(['message' => 'Failed to update job position'], 500);
    }

}
?>