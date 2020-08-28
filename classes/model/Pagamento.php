<?php

class Pagamento{
    public $id;
    public $total_venda;
    public $valor_pagamento;
    public $id_venda;
    public $data_pagamento;


    function __construct(){

    }
   
    public function getId()
    {
        return $this->id;
    }

  
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

  
    public function getTotal_venda()
    {
        return $this->total_venda;
    }

  
    public function setTotal_venda($total_venda)
    {
        $this->total_venda = $total_venda;

        return $this;
    }

    public function getValor_pagamento()
    {
        return $this->valor_pagamento;
    }

 
    public function setValor_pagamento($valor_pagamento)
    {
        $this->valor_pagamento = $valor_pagamento;

        return $this;
    }

   
    public function getId_venda()
    {
        return $this->id_venda;
    }

    public function setId_venda($id_venda)
    {
        $this->id_venda = $id_venda;

        return $this;
    }

    public function getData_pagamento()
    {
        return $this->data_pagamento;
    }

    
    public function setData_pagamento($data_pagamento)
    {
        $this->data_pagamento = $data_pagamento;

        return $this;
    }
}