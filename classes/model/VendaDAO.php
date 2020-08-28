<?php

include_once 'Conexao.php';
include_once 'Picole.php';
include_once 'Cliente.php';



class VendaDAO {

    static function create(Venda $dto) {
        try {
            $picole = new Picole();
            $cliente = new Cliente();
            $db = Conexao::getConexao();
            $stmt = $db->prepare("INSERT INTO venda (id_cliente, id_picole, quantidade,total_venda) VALUES (?,?,?,?)");
            $stmt->bindValue(1, $dto->getId_cliente(), PDO::PARAM_INT);
            $stmt->bindValue(2, $dto->getId_picole(), PDO::PARAM_INT);
            $stmt->bindValue(3, $dto->getQuantidade(), PDO::PARAM_INT);
            $stmt->bindValue(4, $dto->getTotal_venda(), PDO::PARAM_STR);

            $picole->setId($dto->getId_picole());
            $cliente->setId($dto->getId_cliente());
           
            $stmt->execute();
            $id = $db->lastInsertId();
             
        } catch (Throwable $th) {
            $e = new Exception('Erro ao criar venda <br>' . $th->getMEssage());
            throw $e;
        }
    }

    static function update(Venda $dto) {
        try {
            
            $db = Conexao::getConexao();
            $stmt = $db->prepare("UPDATE venda SET id_cliente=?, id_picole=?, quantidade=?, total_venda=? WHERE id=?");
            $stmt->bindValue(1, $dto->getId_cliente(), PDO::PARAM_INT);
            $stmt->bindValue(2, $dto->getId_picole(), PDO::PARAM_INT);
            $stmt->bindValue(3, $dto->getQuantidade(), PDO::PARAM_INT);
            $stmt->bindValue(4, $dto->getTotal_venda(), PDO::PARAM_STR);
            $stmt->bindValue(5, $dto->getId(), PDO::PARAM_INT);

            $stmt->execute();
         
        } catch (Throwable $th) {
            $e = new Exception('Erro ao atualizar venda <br>' . $th->getMEssage());
            throw $e;
        }
    }

    static function delete(Venda $dto) {
        try {
           
            $db = Conexao::getConexao();
            $stmt = $db->prepare("DELETE FROM venda WHERE id=?");
            $stmt->bindValue(1, $dto->getId(), PDO::PARAM_INT);

            $stmt->execute();
            
        } catch (Throwable $th) {
            $e = new Exception('Erro ao remover venda <br>' . $th->getMEssage());
            throw $e;
        }
    }
    static function deleteAllVendaCliente(Venda $dto) {
        try {
           
            $db = Conexao::getConexao();
            $stmt = $db->prepare("DELETE FROM venda WHERE id_cliente=?");
            $stmt->bindValue(1, $dto->getId_cliente(), PDO::PARAM_INT);

            $stmt->execute();
            
        } catch (Throwable $th) {
            $e = new Exception('Erro ao remover todos os clientes da venda <br>' . $th->getMEssage());
            throw $e;
        }
    }
    static function deleteAllVendaPicole(Venda $dto) {
        try {
           
            $db = Conexao::getConexao();
            $stmt = $db->prepare("DELETE FROM venda WHERE id_picole=?");
            $stmt->bindValue(1, $dto->getId_picole(), PDO::PARAM_INT);

            $stmt->execute();
            
        } catch (Throwable $th) {
            $e = new Exception('Erro ao remover todos os picolés da venda <br>' . $th->getMEssage());
            throw $e;
        }
    }

  
    static function readSelectCliente() {
        try {
            $db = Conexao::getConexao();
            $str = "SELECT id AS id_cliente, nome AS nome_cliente, sobrenome AS sobrenome_cliente, apelido FROM cliente ORDER BY nome_cliente";

            $stmt = $db->query($str);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $dtos = $stmt->fetchAll();

            return $dtos;
        } catch (Throwable $th) {
            $e = new Exception('Erro ao ler dados dos clientes cadastrados  <br>' . $th->getMEssage());
            throw $e;
        }
    }

    static function readSelectPicole() {
        try {
            $db = Conexao::getConexao();
            $str = "SELECT id AS id_picole, sabor AS sabor_picole FROM picole WHERE quantidade > 0 ORDER BY sabor";

            $stmt = $db->query($str);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $dtos = $stmt->fetchAll();

            return $dtos;
        } catch (Throwable $th) {
            $e = new Exception('Erro ao ler dados dos picolés cadastrados  <br>' . $th->getMEssage());
            throw $e;
        }
    }

    static function read() {
        try {
            $db = Conexao::getConexao();
            $str = "SELECT venda.id, cliente.nome AS nome_cliente, cliente.id AS id_cliente, cliente.apelido AS apelido_cliente, cliente.sobrenome AS sobrenome_cliente, picole.id AS id_picole, picole.sabor AS sabor_picole, venda.quantidade, data_venda, setor, picole.preco, venda.total_venda FROM venda INNER JOIN cliente ON cliente.id = venda.id_cliente INNER JOIN picole ON venda.id_picole = picole.id ORDER BY venda.data_venda desc";

            $stmt = $db->query($str);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Venda');

            $dtos = $stmt->fetchAll();


            return $dtos;
        } catch (Throwable $th) {
            $e = new Exception('Erro ao ler dados da venda <br>' . $th->getMEssage());
            throw $e;
        }
    }

}
