<?php
// api/src/JobPosition.php

namespace App;
use PDO;
class JobPosition
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function createJobPosition($companyId, $name, $description, $jobLevel)
    {
        $sql = "INSERT INTO job_positions (company_id, name, description, job_level, created_at, updated_at) VALUES (:company_id, :name, :description, :job_level, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);
    
        // Bind parameters and execute the statement
        $stmt->bindParam(':company_id', $companyId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':job_level', $jobLevel, PDO::PARAM_STR);
    
        $result = $stmt->execute();
    
        return $result;
    }
    


    public function listJobPositions()
    {
        $sql = "SELECT * FROM job_positions";
        $result = $this->conn->query($sql);
    
        if ($result === false) {
            echo "Failed to fetch job positions: " . $this->conn->errorInfo()[2];
            return [];
        }
    
        $jobPositions = $result->fetchAll(PDO::FETCH_ASSOC);
        return $jobPositions;
    }
   
    
    public function updateJobPosition($jobPositionId, $companyId, $name, $description, $jobLevel)
    {
        $sql = "UPDATE job_positions SET company_id = :company_id, name = :name, description = :description, job_level = :job_level, updated_at = NOW() WHERE job_position_id = :job_position_id";
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindParam(':company_id', $companyId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':job_level', $jobLevel, PDO::PARAM_STR);
        $stmt->bindParam(':job_position_id', $jobPositionId, PDO::PARAM_INT);
    
        $result = $stmt->execute();
    
        return $result;
    }
    
   

   
}
?>