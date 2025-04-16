<?php

use App\Interface\DAOInterface;
use App\Services\database_connection;
use App\Models\CTSP;

class CTSP_DAO{
    public function insert($e): int
    {
        $sql = "INSERT INTO CTSP (idSP, soSeri) 
        VALUES (?, ?)";
        $args = [$e->getIdSP(), $e->getSoSeri()];
        return database_connection::executeQuery($sql, ...$args);
    }
    public function getById($seri)
    {
        $query = "SELECT * FROM ctsp WHERE SOSERI = ? AND TRANGTHAIHD = 1";
        $result = database_connection::executeQuery($query, [$seri]); // đảm bảo tham số là mảng
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new CTSP($row['IDSP'], $row['SOSERI'], $row['TRANGTHAIHD']);
        }
    
        return null;
    }
    
}