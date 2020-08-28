<?php

class Picole {

    public $id;
    public $sabor;
    public $quantidade;
    public $preco;

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

 
    public function getSabor()
    {
        return $this->sabor;
    }

   
    public function setSabor($sabor)
    {
        $this->sabor = $sabor;

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

    public function getPreco()
    {
        return $this->preco;
    }

   
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }
}