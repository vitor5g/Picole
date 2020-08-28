<?php

class Historico_Venda{
   public $id;
   public $nome_cliente;
   public $sabor_picole;
   public $quantidade_picole;
   public $data_venda;
   public $setor_cliente;
   public $preco_picole;
   public $total;
   public $apelido_cliente;

   
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
 
   public function getNome_cliente()
   {
      return $this->nome_cliente;
   }

  
   public function setNome_cliente($nome_cliente)
   {
      $this->nome_cliente = $nome_cliente;

      return $this;
   }

   public function getSabor_picole()
   {
      return $this->sabor_picole;
   }

 
   public function setSabor_picole($sabor_picole)
   {
      $this->sabor_picole = $sabor_picole;

      return $this;
   }

   public function getQuantidade_picole()
   {
      return $this->quantidade_picole;
   }

 
   public function setQuantidade_picole($quantidade_picole)
   {
      $this->quantidade_picole = $quantidade_picole;

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

   public function getSetor_cliente()
   {
      return $this->setor_cliente;
   }

   
   public function setSetor_cliente($setor_cliente)
   {
      $this->setor_cliente = $setor_cliente;

      return $this;
   }

   public function getPreco_picole()
   {
      return $this->preco_picole;
   }

 
   public function setPreco_picole($preco_picole)
   {
      $this->preco_picole = $preco_picole;

      return $this;
   }
 
   public function getTotal()
   {
      return $this->total;
   }

  
   public function setTotal($total)
   {
      $this->total = $total;

      return $this;
   }

   
   public function getApelido_cliente()
   {
      return $this->apelido_cliente;
   }
 
   public function setApelido_cliente($apelido_cliente)
   {
      $this->apelido_cliente = $apelido_cliente;

      return $this;
   }
}
?>