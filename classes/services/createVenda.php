<?php

include_once '../model/Venda.php';
include_once '../model/VendaDAO.php';

try {
    $data = json_decode($_POST['data']);

    $dto = new Venda();

    $dto->setId_cliente(trim($data->id_cliente));
    $dto->setId_picole(trim($data->id_picole));
    $dto->setQuantidade(trim($data->quantidade));
    $dto->setTotal_venda(trim($dto->getQuantidade() * $data->preco));


    if ($dto->getId_cliente() == '' || $dto->getId_cliente() == 'Selecione') {
        throw new Exception("Cliente é indispensável");
    }
    if ($dto->getId_picole() == '' || $dto->getId_picole() == 'Selecione') {
        throw new Exception("Picolé é indispensável");
    }
    if ($dto->getQuantidade() == 0 || $dto->getQuantidade() == '') {
        throw new Exception("Quantidade não pode ser 0 ou vazio");
    }
    if(ctype_space($dto->getId_cliente()) || 
            ctype_space($dto->getId_picole()) || 
            ctype_space($dto->getQuantidade())){
        throw new Exception("Por favor preencha o campo corretamente, campos preenchidos somente com espaços não são permitidos");
    }else if($dto->getId_cliente() === "0" ||
            $dto->getId_picole() === "0" ||
            $dto->getQuantidade() === "0"){
        throw new Exception("Por favor preencha o campo corretamente, preenchimento com 0 (zero) não são permitidos");
                
    }

    VendaDAO::create($dto);



    http_response_code(200);

    echo 'Venda criada com sucesso';
} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}