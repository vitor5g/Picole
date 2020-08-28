<?php
//inclui arquivo
include_once 'Conexao.php';
//inclui arquivo
include_once 'Historico_Venda.php';

//cria classe Historico_VendaDAO
class Historico_VendaDAO {

    //cria função read que recebe 2 variaveis um $filto ou uma $order para clausula WHERE e ORDER BY do SQL respectivamente
    static function read($filtro, $order) {
        //inicia try
        try {
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria uma variavel $str que recebe o SQL para realizar o SELECT no BD
            $str = "SELECT * FROM historico_venda";
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

            //Define o modo de carga de dados para esta instrução como a classe Picole 
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Historico_Venda');

            //Retorna um array contendo todas as linhas do conjunto de resultados
            $dtos = $stmt->fetchAll();

            //retorna a variavel $dtos contendo os dados do SELECT            
            return $dtos;
            //fim do try inico do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao ler dados do Historico das Vendas <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }

    static function readSelectCliente() {
        try {
            $db = Conexao::getConexao();
            $str = "SELECT DISTINCT(nome_cliente), apelido_cliente FROM historico_venda ORDER BY nome_cliente";

            $stmt = $db->query($str);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $dtos = $stmt->fetchAll();

            return $dtos;
        } catch (Throwable $th) {
            $e = new Exception('Erro ao ler dados do Historico dos Clientes  <br>' . $th->getMEssage());
            throw $e;
        }
    }

    static function readSelectPicole() {
        try {
            $db = Conexao::getConexao();
            $str = "SELECT DISTINCT(sabor_picole) FROM historico_venda ORDER BY sabor_picole";

            $stmt = $db->query($str);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $dtos = $stmt->fetchAll();

            return $dtos;
        } catch (Throwable $th) {
            $e = new Exception('Erro ao ler dados do Historico de picolés <br>' . $th->getMEssage());
            throw $e;
        }
    }

}
