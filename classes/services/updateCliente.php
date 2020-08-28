<?php

include_once "../model/Cliente.php";
include_once "../model/ClienteDAO.php";
 
try {

    $data = json_decode($_POST['data']);

    $dto = new Cliente();

    $dto->setNome(trim($data->nome));
    $dto->setSobrenome(trim($data->sobrenome));
    $dto->setApelido(trim($data->apelido));
    $dto->setSetor(trim($data->setor));
    $dto->setId(trim($data->id));

    if ($dto->getNome() == '' && $dto->getApelido() == '') {
        throw new Exception("Por favor preencha Nome ou Apelido esses campos são indispensáveis");
    }else if(ctype_space($dto->getNome()) || 
            ctype_space($dto->getSobrenome()) || 
            ctype_space($dto->getSetor()) ||
            ctype_space($dto->getApelido())){
        throw new Exception("Por favor preencha o campo corretamente, campos preenchidos somente com espaços não são permitidos");
    }else if($dto->getNome() === "0" ||
            $dto->getSobrenome() === "0" ||
            $dto->getSetor() === "0" ||
            $dto->getApelido() === "0"){
        throw new Exception("Por favor preencha o campo corretamente, preenchimento com 0 (zero) não são permitidos");
                
    }

    ClienteDAO::update($dto);

    http_response_code(200);

    echo 'Cliente atualizado com sucesso';
} catch (Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}


