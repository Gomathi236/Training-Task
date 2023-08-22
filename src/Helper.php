<?php
// src/Helper.php

namespace App;

class Helper
{
    public static function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    
}
?>
