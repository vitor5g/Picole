<?php

include_once "../model/Cliente.php";
include_once "../model/ClienteDAO.php";

try {

    $dtos = ClienteDAO::read('', '');
    if (isset($dtos)) {
        echo json_encode($dtos);
    } else {
        echo json_encode(Array());
    }
    http_response_code(200);
} catch (Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}


?>