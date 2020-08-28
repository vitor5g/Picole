<?php

include_once '../model/Venda.php';
include_once '../model/VendaDAO.php';

try {

    $dtos = VendaDAO::read();
    
   
    if (isset($dtos)) {

        echo json_encode($dtos);
    
    } else {
        echo json_encode(Array());
    }


    http_response_code(200);
} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}