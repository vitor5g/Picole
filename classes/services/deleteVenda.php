<?php

    include_once '../model/Venda.php';
    include_once '../model/VendaDAO.php';
    
    try {
        $data = json_decode($_POST['data']);

        $dto = new Venda();

       
        $dto->setId(trim($data->id));
        
        VendaDAO::delete($dto);


        http_response_code(200);



        echo 'Venda removida com sucesso';

    } catch (\Throwable $th) {
        http_response_code(500);
        echo $th->getMessage();
    }