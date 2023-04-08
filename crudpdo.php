<?php

//CONECCAO COM A BASE DE DADOS
try{
    $pdo = new PDO("mysql:dbname=crudpdo; host=localhost","root","");

    echo "Conectado com sucesso!";
} catch (PDOException $e){
    echo "Erro na coneccao com a base de dados: ".$e->getMessage();

} catch (Exception $e){
    echo "Outros erros: ".$e->getMessage();

}

//------------------------INSERT-------------------------
//1a forma:
/*$res = $pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES(:n, :t, :e)"); 


$cmd->bindValue(":n","Edwin");
$cmd->bindValue(":t","111111111");
$cmd->bindValue(":e","teste@gmail.com");
$cmd->execute();*/




//2a forma:
//$pdo->query("INSERT INTO pessoa (nome, telefone, email) VALUES('Alberto','222222222','Albert@gmail.com')");


//-----------------------------DELETE-------------------------
/*$cmd = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");

$id = 2;
$cmd->bindValue("id","$id");
$cmd->execute();*/



//2a forma:
//$pdo->query("DELETE FROM pessoa WHERE nome='Alberto'");

//-------------------------UPDATE-------------------------------

/*$cmd = $pdo->prepare("UPDATE pessoa SET nome=:n WHERE id=:id ");

$cmd->bindValue(":n","Banda");
$cmd->bindValue("id",4);
$cmd->execute();*/

//2a forma:
//$pdo->query("UPDATE pessoa SET nome = 'Junior' WHERE id = '3'");


//--------------------------SELECT-------------------------------------

$cmd = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");

$cmd->bindValue(":id",4);
$cmd->execute();
$resultado = $cmd->fetch(PDO::FETCH_ASSOC);
foreach ($resultado as $key => $value) {
    echo $key.": ".$value."<br>";
}
//OU
//$cmd->fetchAll();