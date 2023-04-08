<?php
require_once("classepessoa.php");
$p = new pessoa("crudpdo", "localhost", "root", "");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de pessoas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_POST["nome"])) { //Clicou no botao Cadastrar ou Actualizar

        //-----------------------Actualizar--------------------------
        if (isset($_GET["id_up"]) && !empty($_GET["id_up"])) {
            $id_update = addslashes($_GET["id_up"]);
            $nome = addslashes($_POST["nome"]);
            $telefone = addslashes($_POST["telefone"]);
            $email = addslashes($_POST["email"]);
            if (!empty($nome) && !empty($telefone) && !empty($email)) {
                //Cadastrar
                $p->actualizarDados($id_update, $nome, $telefone, $email);
            } else {
    ?>
                <div class="aviso">
                    <h4>

                        Preencha todos os campos!
                    </h4>
                </div>
                <?
            }
            header("location:projecto.php");
            //-----------------------Cadastrar----------------------------
        } else {

            $nome = addslashes($_POST["nome"]);
            $telefone = addslashes($_POST["telefone"]);
            $email = addslashes($_POST["email"]);
            if (!empty($nome) && !empty($telefone) && !empty($email)) {
                //Cadastrar
                if (!$p->cadastrarpessoa($nome, $telefone, $email)) {
                ?>
                    <div class="aviso">
                        <h4>

                            Email ja esta cadastrado!
                        </h4>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="aviso">
                    <h4>

                        Preencha todos os campos!
                    </h4>
                </div>

    <?php
            }
        }
    }

    ?>
    <?php
    if (isset($_GET["id_up"])) { //Verifica se clicou no botao editar
        $id_update = addslashes($_GET["id_up"]);
        $res = $p->buscarDadosPessoa($id_update);
    }


    ?>
    <section id="esquerda">
        <form action="" method="post">
            <h2>Cadastrar pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if (isset($res)) {
                                                                echo $res["nome"];
                                                            } ?>">
            <label for="telefone">Telefone</label>
            <input type="number" name="telefone" id="telefone" value="<?php if (isset($res)) {
                                                                            echo $res["telefone"];
                                                                        } ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if (isset($res)) {
                                                                    echo $res["email"];
                                                                } ?>">
            <input type="submit" value="<?php if (isset($res)) {
                                            echo "Actualizar";
                                        } else {
                                            echo "Cadastrar";
                                        } ?>">
        </form>

    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <td colspan="2">Email</td>

            </tr>
            <?php
            $dados = $p->buscardados();
            if (count($dados) > 0) {
                for ($i = 0; $i < count($dados); $i++) {
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        if ($k != "id") {
                            echo "<td>" . $v . "</td>";
                        }
                    }
            ?>
                    <td>
                        <a href="projecto.php?id_up=<?php echo $dados[$i]["id"] ?>">Editar</a>
                        <a href="projecto.php?id=<?php echo $dados[$i]["id"] ?>">Excluir</a>
                    </td>
                <?php
                    echo "</tr>";
                }
            } else {
                ?>
                <div class="aviso">
                    <h4>

                        Ainda nao ha pessoas cadastradas!
                    </h4>
                </div>
            <?php
            }


            ?>


        </table>

    </section>

</body>

</html>

<?php
if (isset($_GET["id"])) {
    $id_pessoa = addslashes($_GET["id"]);
    $p->excluirpessoa($id_pessoa);
    header("location: projecto.php");
}

?>