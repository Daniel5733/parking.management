<?php 

function conectaDB() {
    $host = "127.0.0.1";
    $user = 'root';
    $pass = 'root';
    $database = 'gest_parque';
    $port = '8889';
    
    return mysqli_connect($host, $user, $pass, $database, $port);
}

function inserir($query) {
    try {
        $con = conectaDB();
        mysqli_query($con, $query);
        return mysqli_insert_id($con);
    } catch(Exception $e) {
        return $e->getMessage();
    }
}

function actualizar($query) {
    try {
        $con = conectaDB();
        mysqli_query($con, $query);
        return true;
    } catch(Exception $e) {
        return false;
    }
}


function apagar($query) {
    try {
        $con = conectaDB();
        mysqli_query($con, $query);
        return true;
    } catch(Exception $e) {
        return false;
    }
}

?>