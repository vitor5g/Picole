<?php

include_once '../model/Pagamento.php';
include_once '../model/PagamentoDAO.php';

try {
    $data = json_decode($_POST['data']);

    $dto = new Pagamento();

    $dto->setId_venda(trim($data->id_venda));
    

    if(empty($dto->getId_venda())){
        throw new Exception("Error ao pegar o id de Venda");
    }

    $dtos = PagamentoDAO::read('id_venda = '.$dto->getId_venda(),'data_pagamento desc');


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