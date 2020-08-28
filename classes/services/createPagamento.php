<?php

include_once '../model/Pagamento.php';
include_once '../model/PagamentoDAO.php';

try {
    $data = json_decode($_POST['data']);

    $dto = new Pagamento();

    $dto->setTotal_venda(trim($data->total_venda));
    $dto->setValor_pagamento(trim($data->valor_pagamento));
    $dto->setId_venda(trim($data->id_venda));

    if(ctype_space($dto->getTotal_venda()) || 
            ctype_space($dto->getValor_pagamento())){
        throw new Exception("Por favor preencha o campo corretamente, campos preenchidos somente com espaços não são permitidos");
    }else if($dto->getTotal_venda() === "0" ||
            $dto->getValor_pagamento() === "0"){
        throw new Exception("Por favor preencha o campo corretamente, preenchimento com 0 (zero) não são permitidos");
                
    }


    PagamentoDAO::create($dto);



    http_response_code(200);

    echo 'Pagamento criada com sucesso';
} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}