<?php

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

if($_SERVER['REQUEST_METHOD'] == "GET"){
    try{
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:users.db');
        // Set errormode to exceptions
        $file_db->setAttribute(
            PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION);
    
        $statement = $file_db->prepare("SELECT rowid, name, mail, service FROM users");
        $statement -> execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // close the database connection
        $file_db = NULL;

        echo json_encode($results);
        
    }catch(PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name = $_POST['name'];
    $mail = $_POST['mail'];

    try{
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:users.db');
        // Set errormode to exceptions
        $file_db->setAttribute(
            PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION);

        $file_db->exec("INSERT INTO 'users' ('name', 'mail', 'service') VALUES ('".$name."', '".$mail."', 1);");
        
        $statement = $file_db->prepare("SELECT rowid, name, mail, service FROM users");
        $statement -> execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // close the database connection
        $file_db = NULL;

        echo json_encode($results);

    }catch(PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $rawData = file_get_contents("php://input");
    $deleteData = [];
    parse_str($rawData, $deleteData);

    $id = $deleteData['id'];

    try{
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:users.db');
        // Set errormode to exceptions
        $file_db->setAttribute(
            PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION);

        $file_db->exec("DELETE FROM 'users' WHERE rowid = '$id'");
        
        $statement = $file_db->prepare("SELECT rowid, name, mail, service FROM users");
        $statement -> execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // close the database connection
        $file_db = NULL;

        echo json_encode($results);

    }catch(PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $rawData = file_get_contents("php://input");
    $putData = [];
    parse_str($rawData, $putData);

    $id = $putData['id'];
    $name = $putData['name'];
    $mail = $putData['mail'];
    $service = '';
    switch($putData['service']) {
        case 'true': 
            $service = 1;
            break;
        case 'false':
            $service = 0;
            break;
        default:
            $service = $putData['service'];
    }

    try{
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:users.db');
        // Set errormode to exceptions
        $file_db->setAttribute(
            PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION);

        $file_db->exec("UPDATE 'users' SET name = '$name', mail = '$mail', service = '$service' WHERE rowid = '$id'");
        
        $statement = $file_db->prepare("SELECT rowid, name, mail, service FROM users");
        $statement -> execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // close the database connection
        $file_db = NULL;

        //echo json_encode($results);

    }catch(PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
    }
}