<?php

class Cliente{
    public $id;
    public $nome;
    public $sobrenome;
    public $setor;
    public $apelido;


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

    
    public function getNome()
    {
        return $this->nome;
    }

  
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }

 
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;

        return $this;
    }

    public function getSetor()
    {
        return $this->setor;
    }

  
    public function setSetor($setor)
    {
        $this->setor = $setor;

        return $this;
    }

    public function getApelido()
    {
        return $this->apelido;
    }

   
    public function setApelido($apelido)
    {
        $this->apelido = $apelido;

        return $this;
    }
}