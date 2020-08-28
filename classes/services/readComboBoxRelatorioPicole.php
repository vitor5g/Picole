<?php

include_once '../model/Historico_Venda.php';
include_once '../model/Historico_VendaDAO.php';


try {

    $dtos = Historico_VendaDAO::readSelectPicole();

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