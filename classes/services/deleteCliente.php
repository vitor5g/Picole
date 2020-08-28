<?php

    include_once "../model/Cliente.php";
    include_once "../model/ClienteDAO.php";
    include_once "../model/Venda.php";
    include_once "../model/VendaDAO.php";
try {

$data = json_decode($_POST['data']);

$dto = new Cliente();

$dto->setId($data->id);

ClienteDAO::delete($dto);

http_response_code(200);

echo 'Cliente removido com sucesso';

} catch (Throwable $th) {
   http_response_code(500);
   echo $th->getMessage();
}


