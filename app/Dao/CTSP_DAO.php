<?php

use App\Interface\DAOInterface;
use App\Services\database_connection;

class CTSP_DAO{
    public function insert($e): int
    {
        $sql = "INSERT INTO CTSP (idSP, soSeri) 
        VALUES (?, ?)";
        $args = [$e->getIdSP(), $e->getSoSeri()];
        return database_connection::executeQuery($sql, ...$args);
    }
}