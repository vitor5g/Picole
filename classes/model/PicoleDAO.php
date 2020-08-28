<?php
//inclui arquivo
include_once 'Conexao.php';
//inclui arquivo
include_once 'VendaDAO.php';
//inclui arquivo
include_once 'Venda.php';

//cria classe PicoleDAO
class PicoleDAO {

    //cria função create que recebe um objeto do tipo Picole como parametro
    static function create(Picole $dto) {
        //inicia try
        try {
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria variavel $stmt que recebe o prepare de $db para preparar o sql para inserir
            $stmt = $db->prepare("INSERT INTO picole (sabor, quantidade, preco) VALUES (?,?,?)");
            //seta o sabor no primeiro parametro das ?
            $stmt->bindValue(1, $dto->getSabor(), PDO::PARAM_STR);
            //seta a quantidade no segundo parametro das ?
            $stmt->bindValue(2, $dto->getQuantidade(), PDO::PARAM_INT);
            //seta o preco no terceiro parametro das ?
            $stmt->bindValue(3, $dto->getPreco(), PDO::PARAM_STR);

            //executa o sql preparado
            $stmt->execute();
            //pega o id da inserção
            $id = $db->lastInsertId();
            //fim do try inicio do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao criar picolé <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }

    //cria função update que recebe um objeto do tipo Picole como parametro
    static function update(Picole $dto) {
        //inicia try
        try {
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria variavel $stmt que recebe o prepare de $db para preparar o sql para atualizar
            $stmt = $db->prepare("UPDATE picole SET sabor=?, quantidade=?, preco=? WHERE id=?");
            //seta o sabor no primeiro parametro das ?
            $stmt->bindValue(1, $dto->getSabor(), PDO::PARAM_STR);
            //seta a quantidade no segundo parametro das ?
            $stmt->bindValue(2, $dto->getQuantidade(), PDO::PARAM_INT);
            //seta o preco no terceiro parametro das ?
            $stmt->bindValue(3, $dto->getPreco(), PDO::PARAM_STR);
            //seta o id no quarto parametro das ?
            $stmt->bindValue(4, $dto->getId(), PDO::PARAM_INT);

            //executa o sql preparado
            $stmt->execute();
            //fim do try inicio do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao atualizar picolé <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }

    //cria função delete que recebe um objeto do tipo Picole como parametro
    static function delete(Picole $dto) {
        //inicia try
        try {
            $venda = new Venda();

            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria variavel $stmt que recebe o prepare de $db para preparar o sql para deletar
            $stmt = $db->prepare("DELETE FROM picole WHERE id=?");
            //seta o id no primeiro parametro das ?
            $stmt->bindValue(1, $dto->getId(), PDO::PARAM_INT);

            $venda->setId_picole($dto->getId());

            VendaDAO::deleteAllVendaPicole($venda);


            //executa o sql preparado
            $stmt->execute();
            //fim do try inicio do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao remover picolé <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }

    //cria função read que recebe 2 variaveis um $filto ou uma $order para clausula WHERE e ORDER BY do SQL respectivamente
    static function read($filtro, $order) {
        //inicia try
        try {
            //cria variavel $db que recebe a conexão com o BD
            $db = Conexao::getConexao();
            //cria uma variavel $str que recebe o SQL para realizar o SELECT no BD
            $str = "SELECT * FROM picole";
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
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Picole');

            //Retorna um array contendo todas as linhas do conjunto de resultados
            $dtos = $stmt->fetchAll();

            //retorna a variavel $dtos contendo os dados do SELECT            
            return $dtos;
            //fim do try inico do catch
        } catch (Throwable $th) {
            //caso dê erro ao inserir exibi a mensagem com o codigo do erro pego no catch
            $e = new Exception('Erro ao ler dados do picolé <br>' . $th->getMEssage());
            //lança a exceção pega na variavel é para ser tratada posteriormente
            throw $e;
        }
    }

}
