<?php

include_once "../model/Picole.php";
include_once "../model/PicoleDAO.php";


try {
    $dtos = PicoleDAO::read('','');

    if(isset($dtos)){
        echo json_encode($dtos);
    }else{
        echo json_encode(Array());
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}