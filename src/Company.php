<?php
// api/src/Company.php

namespace App;
use PDO;
use PDOException;
class Company
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createCompany($name, $address, $domain)
{
    $sql = "INSERT INTO companies (name, address, domain) VALUES (:name, :address, :domain)";
    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':domain', $domain);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // You might want to handle the exception here if needed
        return false;
    }
}
public function listCompanies() {
    $sql = "SELECT * FROM companies";
    $result = $this->conn->query($sql);

    if (!$result) {
        echo "Failed to fetch companies: " . $this->conn->errorInfo()[2]; // Use errorInfo() for PDO
        return [];
    }

    $companies = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) { // Use PDO::FETCH_ASSOC
        $companies[] = $row;
    }

    return $companies;
}


public function updateCompany($companyId, $name, $address, $domain)
{
    $sql = "UPDATE companies SET name = :name, address = :address, domain = :domain, updated_at = NOW() WHERE id = :companyId";
    $stmt = $this->conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':domain', $domain, PDO::PARAM_STR);
    $stmt->bindParam(':companyId', $companyId, PDO::PARAM_INT);

    $result = $stmt->execute();

    return $result;
}
    
    // Implement more CRUD operations for the Company class.
    public function deleteCompany($companyId)
    {
        $sql = "DELETE FROM companies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bind_param("i", $companyId);
        $result = $stmt->execute();

        return $result;
    }
}
?>