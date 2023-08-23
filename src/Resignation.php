<?php
// api/src/Resignation.php

namespace App;
use PDO;
class Resignation
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function applyResignation($employeeId, $companyId, $status, $dateRequested, $reason)
    {
        var_dump($dateRequested);

        $sql = "INSERT INTO resignations (employee_id, company_id, status, date_requested, reason, created_at, updated_at) VALUES (:employee_id, :company_id, :status, :date_requested, :reason, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
        $stmt->bindParam(':company_id', $companyId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':date_requested', $dateRequested, PDO::PARAM_STR);
        $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);

        $result = $stmt->execute();

        return $result;
    }


    public function listResignations()
{
    $sql = "SELECT * FROM resignations";
    $result = $this->conn->query($sql);

    if (!$result) {
        echo "Failed to fetch resignations: " . $this->conn->error;
        return [];
    }

    $resignations = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $resignations[] = $row;
    }

    return $resignations;
}


    public function getResignationById($resignationId)
    {
        $sql = "SELECT * FROM resignations WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bind_param("i", $resignationId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } 
    }

    public function updateResignation($resignationId, $status, $dateRequested, $reason)
    {
        $sql = "UPDATE resignations SET status = :status, date_requested = :date_requested, reason = :reason, updated_at = NOW() WHERE resignation_id = :resignation_id";
        $stmt = $this->conn->prepare($sql);
    
        // Bind parameters
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':date_requested', $dateRequested, PDO::PARAM_STR);
        $stmt->bindValue(':reason', $reason, PDO::PARAM_STR);
        $stmt->bindValue(':resignation_id', $resignationId, PDO::PARAM_INT);
    
        $result = $stmt->execute();
    
        return $result;
    }
    

   
}
?>