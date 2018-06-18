<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");


$myJSON = array(
    array(
        "id" => '0',
        "name" => 'Beth',
        "mail" => 'beth@msn.com'
    ),
    array(
        "id" => '1',
        "name" => 'Meagan',
        "mail" => 'fox.meagan17@gmail.com'
    ),
    array(
        "id" => '2',
        "name" => 'Billy',
        "mail" => 'billystorm94@gmail.com'
    ),
    array(
        "id" => '3',
        "name" => 'Joel',
        "mail" => 'jaguarsixty@yahoo.com'
    ),
);

echo json_encode($myJSON);