<?php

include_once "../model/Picole.php";
include_once "../model/PicoleDAO.php";


try {
    $data = json_decode($_POST['data']);
    $dto = new Picole();

    $dto->setSabor(trim($data->sabor));
    $dto->setQuantidade(trim($data->quantidade));
    $dto->setPreco(trim(str_replace(",", ".",$data->preco )));
    $dto->setPreco(trim(str_replace("R$", " ", $dto->getPreco())));

    if ($dto->getSabor() == '') {
        throw new Exception("Sabor é indispensável");
    }
    if ($dto->getQuantidade() == '') {
        throw new Exception("Quantidade é indispensável");
    }
    if ($dto->getPreco() == '') {
        throw new Exception("Preco é indispensável");
    }
    if(ctype_space($dto->getSabor()) || 
            ctype_space($dto->getQuantidade()) || 
            ctype_space($dto->getPreco())){
        throw new Exception("Por favor preencha o campo corretamente, campos preenchidos somente com espaços não são permitidos");
    }else if($dto->getSabor() === "0" ||
            $dto->getQuantidade() === "0" ||
            $dto->getPreco() === "0"){
        throw new Exception("Por favor preencha o campo corretamente, preenchimento com 0 (zero) não são permitidos");
    }

    PicoleDAO::create($dto);

    http_response_code(200);
    echo 'Picole criado com sucesso';
} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}