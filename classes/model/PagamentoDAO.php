<?php
//inclui arquivo
include_once 'Conexao.php';
//inclui arquivo
include_once 'Pagamento.php';
//inclui arquivo
include_once 'Venda.php';

//cria classe ClienteDAO
class PagamentoDAO
{
    //cria função create que recebe um objeto do tipo Cliente como parametro
    static function create(Pagamento $dto)
    {
        //inicia try
        try {
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria variavel $stmt que recebe o prepare de $db para preparar o sql para inserir
            $stmt = $db->prepare("INSERT INTO pagamento (total_venda, valor_pagamento, id_venda) VALUES (?,?,?)");
            //seta o nome no primeiro parametro das ?
            $stmt->bindValue(1, $dto->getTotal_venda(), PDO::PARAM_STR);
            //seta o sobrenome no segundo parametro das ?
            $stmt->bindValue(2, $dto->getValor_pagamento(), PDO::PARAM_STR);
            //seta o setor no terceiro parametro das ?
            $stmt->bindValue(3, $dto->getId_venda(), PDO::PARAM_INT);
            //executa o sql preparado
            $stmt->execute();


            //pega o id da inserção
            $id = $db->lastInsertId();
            //fim do try inicio do catch
        } catch (PDOException $th) {

            echo $th->getMessage();
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao criar pagamento <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }


    //cria função delete que recebe um objeto do tipo Cliente como parametro
    static function delete(Pagamento $dto)
    {
        //inicia try
        try {
            //cria um objeto do tipo venda com nome venda
            $venda = new Venda();
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria variavel $stmt que recebe o prepare de $db para preparar o sql para deletar
            $stmt = $db->prepare("DELETE FROM cliente WHERE id=?");
            //seta o id no primeiro parametro das ?
            $stmt->bindValue(1, $dto->getId(), PDO::PARAM_INT);

            //seta o id no objeto do tipo venda criado anteriormente
            $venda->setId_cliente($dto->getId());
            //chama a função de venda para deletar todas as vendas daquele cliente passando como paramentro o id do msm
            VendaDAO::deleteAllVendaCliente($venda);


            //executa o sql preparado
            $stmt->execute();
            //fim do try inico do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao pagamento cliente <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }

    //cria função read que recebe 2 variaveis um $filto ou uma $order para clausula WHERE e ORDER BY do SQL respectivamente
    static function read($filtro, $order)
    {
        //inicia try
        try {
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria uma variavel $str que recebe o SQL para realizar o SELECT no BD
            $str = "SELECT * FROM pagamento ";
            //if que verifica se a variavel $filro é diferente de vazio
            if ($filtro != "") {
                //caso $filtro não seja diferente de vazio adiciona string a variavel $str
                $str = $str . " WHERE " . $filtro;
            }
            //if que verifica se a variavel $order é diferente de vazio
            if ($order != "") {
                //caso $order não seja diferente de vazio adiciona string a variavel $str
                $str = $str . " ORDER BY " . $order;
            }


            //executa o sql preparado
            $stmt = $db->query($str);

            //Define o modo de carga de dados para esta instrução como a classe Cliente 
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pagamento');
            //Retorna um array contendo todas as linhas do conjunto de resultados
            $dtos = $stmt->fetchAll();
            //retorna a variavel $dtos contendo os dados do SELECT            
            return $dtos;
            //fim do try inico do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao ler dados do pagamento <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }
}
