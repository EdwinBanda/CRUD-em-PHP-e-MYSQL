<?php
class pessoa{

    private $pdo;
    public function __construct($dbname, $host, $user, $senha){
        try {
            $this-> pdo = new PDO("mysql:dbname=".$dbname.";host:".$host,$user,$senha);
    }catch (PDOException $e) {
        echo "Erro na coneccao de base de dados: ".$e->getMessage();
    
        } catch(Exception $e){
            echo "Outros erros: ".$e->getMessage();
        }
        }

    public function buscardados(){
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY id DESC");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarpessoa($nome, $telefone, $email){

        //Antes verificar se o email ja foi cadastrado
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e",$email);
        $cmd->execute();
        if($cmd->rowCount() > 0) //Email ja existe
        {
            return false;
        }else{
            $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
        }
    }

    public function excluirpessoa($id){
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        return true;

    }

    //Buscar dados de uma pessoa especifica
    public function buscarDadosPessoa($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;


    }






    //Actualizar os dados 
    public function actualizarDados($id,$nome,$telefone,$email){
        


        $cmd= $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
        $cmd->bindValue(":n",$nome);
        $cmd->bindValue(":t",$telefone);
        $cmd->bindValue(":e",$email);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        return true;
        

    }
}


?>