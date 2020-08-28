<?php

include_once "../model/Picole.php";
include_once "../model/PicoleDAO.php";


try {
    $data = json_decode($_POST['data']);
    $dto = new Picole();

    $dto->setId($data->id);
    
    PicoleDAO::delete($dto);

    http_response_code(200);
    echo 'Picole removido com sucesso';

} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}