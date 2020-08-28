<?php

class Venda {

    public $id;
    public $id_cliente;
    public $id_picole;
    public $quantidade;
    public $data_venda;
    public $total_venda;

    function __construct() {
        
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

    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    public function setId_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getId_picole()
    {
        return $this->id_picole;
    }

    
    public function setId_picole($id_picole)
    {
        $this->id_picole = $id_picole;

        return $this;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

 
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

   
    public function getData_venda()
    {
        return $this->data_venda;
    }

   
    public function setData_venda($data_venda)
    {
        $this->data_venda = $data_venda;

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
}
