<?php
session_start();

$video = '1';
$audio = '1';
$texto = '1';

$_SESSION['video'] = $video;
$_SESSION['audio'] = $audio;
$_SESSION['texto'] = $texto;

if (empty($_SESSION['username']) && empty($_SESSION['password']) && empty($_SESSION['nome']) && empty($_SESSION['sobrenome'])) {
    // Ação a ser executada: mata o script e manda uma mensagem
    header("Location: TelaLogin.php");
}
$nome  = $_SESSION['nome'];
$sobrenome = $_SESSION['sobrenome'];
$foto = $_SESSION['foto'];
$id_user_atual = $_SESSION['id_uti'];
$tipo_uti_atual =  $_SESSION['tipo_uti'];

include('./db/connection.php');

if ($tipo_uti_atual == 3) {

?>
    <style>
        #utilizadores {
            display: none;
        }

        #estado {
            display: none;
        }

        #btnGerir {
            display: none;
        }

        .views {
            display: none;
        }
    </style>
<?php
}
if ($tipo_uti_atual == 1) {

?>
    <style>
        #estado {
            display: none;
        }

        #btnGerir {
            display: none;
        }

        #btn1 {
            display: none;
        }
    </style>
    <?php
}
if ($tipo_uti_atual == 2) {

    $sql_departamento  = "SELECT gci.Tipo_departamento from utilizador as uti left join gci on gci.Id_uti_GCI=uti.ID_uti 
    where uti.ID_uti = '$id_user_atual'";

    $result_departamento = mysqli_query($conn, $sql_departamento);

    if ($result_departamento == true) {

        if ($result_departamento->num_rows > 0) {
            $arr = mysqli_fetch_assoc($result_departamento);

            $departamento =  $arr['Tipo_departamento'];

            if ($departamento == 'Gestor de Sistema') {
            } else if ($departamento == 'Web Tv') {
    ?>
                <style>
                    #utilizadores {
                        display: none;
                    }

                    #estado {
                        display: none;
                    }
                </style>
            <?php
            } else if ($departamento == 'Laboratório de Impressa') {
            ?>
                <style>
                    #utilizadores {
                        display: none;
                    }

                    #estado {
                        display: none;
                    }
                </style>
            <?php
            } else if ($departamento == 'Estudio de Rádio') {
            ?>
                <style>
                    #utilizadores {
                        display: none;
                    }

                    #estado {
                        display: none;
                    }
                </style>
            <?php
            } else if ($departamento == 'Avaliador') {
            ?>
                <style>
                    #btnGerir {
                        display: none;
                    }

                    #utilizadores {
                        display: none;
                    }
                </style>
    <?php
            } else {
                echo "erro departamento";
                $conn->close();
            }
        } else {
            echo "erro ao executar query";
            $conn->close();
        }
    } else {
        echo "erro ao executar query";
        $conn->close();
    }
    ?>
    <style>
        #btn1 {
            display: none;
        }
    </style>
<?php
}

if ($tipo_uti_atual != 3) {

?>
    <style>
        #favoritos {
            display: none;
        }

        .views1 {
            display: none;
        }

        .area_star {
            display: none;
        }
    </style>
<?php
}
?>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Conta'm Xtoria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Tela_Principal.css">
</head>

<script src="./javascript/jquery-3.5.1.min.js"></script>

<body>
    <header class="navegacao">
        <div class="logo">
            <a href="TelaInicial.php"><img src="img/icons/logo.svg" alt="" height="40" width="112"></a>
        </div>

        <form class="pesquisa" action="pesquisar.php" method="POST">
            <img id="img_loupe" src="./img/icons/loupe.svg" alt="">
            <input name="pesq" type="search" placeholder="Pesquisar">
        </form>

        <div id="conteudo">
            <a href="TelaInicial.php"><img id="img_user" src="./img/icons/Apps_Orange.svg" alt="conteúdo" style="margin-left: 16px;">
                <p style="color: #E83320;">Conteúdo</p>
            </a>
        </div>

        <div id="favoritos">
            <a href="TelaFavoritos.php"><img id="img_user" src="./img/icons/StarRatings.svg" alt="Favoritos" style="margin-left: 15px;">
                <p>Favoritos</p>
            </a>
        </div>

        <div id="estatistica">
            <a href="TelaTopDez.php"><img id="img_user" src="./img/icons/AnalyticsGraphChart.svg" alt="estatistica" style="margin-left: 25px;">
                <p>Estatísticas</p>
            </a>
        </div>

        <div id="utilizadores">
            <a href="TelaGerir.php"><img id="img_user" src="./img/icons/UserGroupAccounts.svg" alt="utilizadores" style="margin-left: 25px;">
                <p>Utilizadores</p>
            </a>
        </div>

        <div id="per">
            <a href="#"><img id="img_user" src=<?php echo $foto; ?> alt="perfil"><span id="name_user"><?php echo $nome . ' ' . $sobrenome; ?></span></a>

            <div class="dropdown-content">
                <a href="TelaPerfil.php">Ver Perfil</a>
                <a href="Logout.php">Terminar Sessão</a>
            </div>
        </div>

    </header>

    <div id="principal">

        <div class="main">

            <div id="myModalConf" class="modal">
                <div class="modal-contentConf" style="border-radius: 1%;">
                    <span onclick="cancelar()" class="close">&times;</span>
                    <h3 style="margin: 0% 0% 2% 0%;">Deseja proceder com a operação?</h3>

                    <div style="display: flex; margin-left: 33.5%; margin-top: 20px;">
                        <button id="yes" class="btn11" onclick="sim()">Sim</button>
                        <button id="no" class="btn22" onclick="nao()">Não</button>
                    </div>
                </div>
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content" style="border-radius: 1%;">
                    <span onclick="cancelar()" class="close">&times;</span>
                    <h1 style="margin: 0% 0% 2% 0%;">Adcionar conteúdo</h1>
                    <hr style="width: 97%; margin: 0;">

                    <div id="pef">
                        <img src=<?php echo $foto; ?> alt="Foto Perfil" style="width: 50px; height: 50px;" id="fotoperfil">
                        <p style="margin: 5px 0px 0px 10px"><?php echo $nome . ' ' . $sobrenome; ?></p>
                    </div>

                    <form id="formulario" style="padding: 0% 7%;">
                        <div style="display: flex;  margin-top: 20px; justify-content: space-between;">
                            <div style="width: 100%;">
                                <p style="margin: 0;">Titulo</p>
                                <input required type="text" id="titulo" class="inputsAdd" placeholder="Titulo do Conteúdo">
                            </div>
                        </div>

                        <div style="display: flex;  margin-top: 20px; justify-content: space-between;">
                            <div style="width: 49%;">
                                <p style="margin: 0;">Produtor</p>
                                <input required type="text" id="produtor" class="inputsAdd" placeholder="Username do produtor">
                            </div>
                            <div style="width: 49%;">
                                <p style="margin: 0;">Autor</p>
                                <input required type="text" id="autor" class="inputsAdd" placeholder="Autor do Conteúdo">
                            </div>
                        </div>

                        <div style="display: flex;  margin-top: 20px; justify-content: space-between;">
                            <div>
                                <label for="tipo" style="width: 120px;">Categoria:</label><br>
                                <select name="tipoC" id="tipoC" class="tipo_c" required>
                                    <option value=""></option>
                                    <option value="hist">História Antiga</option>
                                    <option value="anedt">Anedotas</option>
                                    <option value="prover">Provérbios</option>
                                    <option value="advi">Advinhas</option>
                                    <option value="cont">Contos</option>
                                </select>
                            </div>

                            <div style="width: 49%;">
                                <p style="margin: 0;">Data Produção</p>
                                <input required type="date" name="" id="dataProducao" class="inputsAdd">
                            </div>
                        </div>
                        <div>
                            <p>Adcione o ficheiro</p>
                            <input required type="file" id="ficheiro" name="avatar" accept="application/pdf,video/mp4,audio/mp3">
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
                            <button type="submit" id="btn11" class="btnPositive" onclick="guardar()">Publicar Conteúdo</button>
                            <button onclick="cancelar()" class="btnNegative">Cancelar</button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="filtro" style="display: flex;">
                <div>
                    <div class="listar1">
                        <form action="" method="POST">
                            <label for="tipoLista1">Listar por:</label><br>
                            <select name="tipoLista1" id="tipo_c">
                                <option value="recentes">Mais Recentes</option>
                                <option value="antigos">Mais Antigos</option>
                                <option value="decrescente">Mais Visualizados</option>
                                <option value="crescente">Menos Visualizados</option>
                            </select>
                            <button class="filt" type="submit" id="btnFil">Filtrar</button>
                            <br><br>
                        </form>
                    </div>
                    <div class="listar">
                        <form id="estado" method="POST">
                            <label for="tipo">Estado:</label><br>
                            <select name="tipoLista2" id="tipo_c">
                                <option value="disponivel">Disponível</option>
                                <option value="indisponivel">Indisponível</option>
                            </select>
                            <button class="filt" type="submit" id="btnEstado">Filtrar</button>
                            <br><br>
                        </form>
                    </div>
                    <div class="listar">
                        <form action="" method="POST">
                            <label for="tipo">Categoria:</label><br>
                            <select name="tipoLista3" id="tipo_c" class="tp" style="width: 70%;">
                                <option value="historias">Histórias antigas</option>
                                <option value="anedotas">Anedotas</option>
                                <option value="provervios">Provérbios</option>
                                <option value="advinha">Adivinhas</option>
                                <option value="contos">Contos</option>
                            </select>
                            <button class="filt" type="submit" id="btn40">Filtrar</button>
                            <br><br>
                        </form>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">

                <div class="tipo">
                    <a href="TelaInicialTexto.php"><img src="img/icons/PaperFileText_Gray.svg" alt="" width="40" height="40" class="ttc1"></a>
                    <a href="TelaInicialVideo.php"><img src="img/icons/YoutubeVideo_Gray.svg" alt="" width="40" height="40" class="ttc"></a>
                    <a href="TelaInicialAudio.php"><img src="img/icons/MusicNote_Gray.svg" alt="" width="40" height="40" class="ttc"></a>
                </div>
                <div class="botoes">
                    <button class="btn" id="btnGerir" onclick="location.href='GerirConteudo.php'">Gerir Conteúdos</button>
                    <button id="btn1" class="btn" onclick="adcionar()">Adicionar Conteúdo</button>
                </div>
            </div>

            <?php

            $username = $_SESSION['username'];

            $tipoFiltro = array_key_exists('tipoLista1', $_POST) ? trim($_POST['tipoLista1']) : 'recentes';
            $tipoEstado = array_key_exists('tipoLista2', $_POST) ? trim($_POST['tipoLista2']) : null;
            $tipoCategoria = array_key_exists('tipoLista3', $_POST) ? trim($_POST['tipoLista3']) : null;

            if ($tipoFiltro == 'recentes' && $tipoEstado == null && $tipoCategoria == null) {

                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1
                order by cont_form.Data_publicacao desc";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoFiltro == 'antigos' && $tipoEstado == null && $tipoCategoria == null) {

                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1
                order by cont_form.Data_publicacao asc";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoFiltro == 'crescente' && $tipoEstado == null && $tipoCategoria == null) {

                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1
                ORDER BY cont_form.Numero_visualizacao asc";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoFiltro == 'decrescente' && $tipoEstado == null && $tipoCategoria == null) {

                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1
                ORDER BY cont_form.Numero_visualizacao desc";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoEstado == 'disponivel') {

                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoEstado == 'indisponivel') {
                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 0";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoCategoria == 'historias') {
                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1 and tipo_cont.ID_tipo_cont = 1";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoCategoria == 'anedotas') {
                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1 and tipo_cont.ID_tipo_cont = 4";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoCategoria == 'provervios') {
                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1 and tipo_cont.ID_tipo_cont = 5";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoCategoria == 'advinha') {
                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1 and tipo_cont.ID_tipo_cont = 3";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else if ($tipoCategoria == 'contos') {
                $sql =  "SELECT cont_form.Codigo_c as id_cont, cont_form.Id_form as id_form, cont.Titulo, cont.Autor, tipo_cont.Tipo, uti_prod.Username as Produtor, uti_publ.Username as Publicador,
                uti_publ.foto as Foto_Publicador, cont_form.Data_publicacao, cont_form.Data_producao,
                uti_aval.Username as Avaliador, cont_form.Numero_visualizacao as vizualizacao,
                cont_form.Curtidas as Likes, cont_form.Corpo as caminho, form.Tipo as extensao, cont_form.Estado as est  
                FROM conteudo AS cont 
                left JOIN tipoconteudo AS tipo_cont ON tipo_cont.ID_tipo_cont=cont.Tipo_cont
                left JOIN conteudoformato AS cont_form ON cont_form.Codigo_c=cont.Codigo
                left JOIN formato AS form ON form.ID_formato = cont_form.id_form
                left JOIN utilizador AS uti_prod ON uti_prod.ID_uti=cont_form.Id_produtor
                left JOIN utilizador AS uti_publ ON uti_publ.ID_uti=cont_form.Id_publicador
                left JOIN utilizador AS uti_aval ON uti_aval.ID_uti=cont_form.Id_avaliador
                where cont_form.Estado = 1 and tipo_cont.ID_tipo_cont = 2";

                $result = mysqli_query($conn, $sql);

                if ($result == true) {

                    if ($result->num_rows > 0) {
                        $num_coluna = mysqli_num_fields($result);
                        $num_linha = mysqli_num_rows($result);
                        $array = array();

                        for ($i = 0; $i < $num_linha; $i++) {
                            $array_2 = mysqli_fetch_assoc($result);
                            $array[$i] = $array_2;
                        }
                    } else {
                        echo "erro ao executar query";
                        $conn->close();
                    }
                } else {
                    echo "erro ao executar query";
                    $conn->close();
                }
            } else {
                echo 'err filtro';
            }
            ?>

            <div class="conteudo">

                <?php
                for ($ic = 0; $ic < $num_linha; $ic++) {

                    if ($array[$ic]['extensao'] == 'Áudio') {
                        $doc = "img/icons/MusicNote_Gray.svg";
                        $img = "media/Audio.png";
                    } else if ($array[$ic]['extensao'] == 'Vídeo') {
                        $doc = "img/icons/YoutubeVideo_Gray.svg";
                        $img = "media/Video.png";
                    } else {
                        $doc = "img/icons/PaperFileText_Gray.svg";
                        $img = "media/Text.png";
                    }
                ?>
                    <div class="item">

                        <div class="prim">
                            <a href="#"><img src=<?php echo $array[$ic]['Foto_Publicador']; ?> alt="" class="it" width="30" height="30">
                                <h4><?php print_r($array[$ic]['Publicador']);   ?></h4>
                            </a>
                            <a href="#" class="mus"><img src="<?php echo $doc ?>" alt="" width="20" height="20"></a>
                        </div>

                        <div class="it" id="documento" onclick="alerta(<?php echo $array[$ic]['id_cont']; ?>,<?php echo $array[$ic]['id_form']; ?>,<?php echo $id_user_atual; ?>)">
                            <p class="tt"><?php print_r($array[$ic]['Titulo']);  ?></p>
                            <div style="display: flex; justify-content: space-between">
                                <p class="av">
                                    <?php print_r(implode("/", array_reverse(explode("-", $array[$ic]['Data_publicacao']))));  ?>
                                </p>
                                <div style="display: flex; font-size: 11px; margin-right: 18px;">
                                    <p class="views1" style="margin:0px 5px 0px 0px;">
                                        <?php echo $array[$ic]['vizualizacao']; ?></p> <img class="views1" src="img/icons/EyePasswordShow.svg" alt="Visualizações" width="15" height="15">
                                </div>
                            </div>

                            <img src="<?php echo $img ?>" alt="" width="266" height="142">
                        </div>

                        <div class="interact">

                            <div class="likes">

                                <?php

                                $id_cont  = $array[$ic]['id_cont'];
                                $id_form  = $array[$ic]['id_form'];
                                $curtidas = $array[$ic]['Likes'];
                                
                                $sql_like = "SELECT users.ID_uti FROM likes  JOIN utilizador as users on likes.id_user=users.ID_uti
                                JOIN conteudoformato as cf on cf.Codigo_c=likes.Codigo_c
                                JOIN formato as form on form.ID_formato=likes.if_form
                                WHERE users.Username='$username' and cf.Codigo_c='$id_cont' and form.ID_formato='$id_form'";

                                $resultado_like = mysqli_query($conn, $sql_like);

                                if ($resultado_like == true) {

                                    if ($resultado_like->num_rows > 0) {
                                        //echo $resultado_like->num_rows;
                                        $array_1 = mysqli_fetch_assoc($resultado_like);
                                        $id_user = $array_1['ID_uti'];
                                        //print_r($array_1 );
                                        //$conn->close();
                                        $id_img = $id_cont . '' . $id_form;
                                        $id_like = $ic;
                                ?>
                                        <div class="like_ao_lado" style="display: flex;">

                                            <img src="img/icons/HeartLoveLike_Filled.svg" id=<?php echo $id_img; ?> alt="" width="17" height="17" class="int" onclick="mudaIcon(<?php echo  $id_cont; ?>,<?php echo  $id_form; ?>,<?php echo  $id_user; ?>,<?php echo $id_img; ?>,<?php echo $id_like; ?>)">
                                            <p class="like" id=<?php echo $id_like; ?>><?php echo  $curtidas; ?></p>

                                        </div>
                                        <?php
                                    } else {

                                        $id_img = $id_cont . '' . $id_form;
                                        $id_like = $ic;

                                        $sql_id = "SELECT users.ID_uti FROM utilizador AS users WHERE users.Username = '$username'";


                                        $resultado_id = mysqli_query($conn, $sql_id);

                                        if ($resultado_id->num_rows > 0) {
                                            //echo 'o user ' . $username . ' curtiu o cont ' . $id_cont . ' no formato ' . $id_form . ' entrou2 ';
                                            $array_1 = mysqli_fetch_assoc($resultado_id);
                                            $id_user = $array_1['ID_uti'];

                                        ?>
                                            <div class="like_ao_lado" style="display: flex;">

                                                <img src="img/icons/HeartLoveLike_Orange.svg" id=<?php echo $id_img; ?> alt="" width="17" height="17" class="int" onclick="mudaIcon(<?php echo $id_cont; ?>,<?php echo $id_form; ?>,<?php echo  $id_user; ?>,<?php echo $id_img; ?>,<?php echo $id_like; ?>)">
                                                <p class="like" id=<?php echo $id_like; ?>><?php echo $curtidas;  ?></p>

                                            </div>
                                <?php
                                        } else {
                                            echo "erro ao carregar dados de base de dados likes";
                                            $conn->close();
                                        }
                                        //$conn->close();
                                    }
                                } else {
                                    echo "erro ao carregar dados de base de dados likes";
                                    $conn->close();
                                }
                                ?>
                            </div>

                            <nav id="divisao"></nav>

                            <?php

                            $sql_favorito = "SELECT users.ID_uti FROM lista_desejo as lista  JOIN utilizador as users on lista.id_user=users.ID_uti
                            JOIN conteudoformato as cf on cf.Codigo_c=lista.cod_cont and cf.Id_form=lista.id_form
                            WHERE users.Username='$username' and cf.Codigo_c='$id_cont' and cf.Id_form='$id_form'";

                            $resultado_favorito = mysqli_query($conn, $sql_favorito);

                            if ($resultado_favorito == true) {

                                if ($resultado_favorito->num_rows > 0) {

                                    $array_3 = mysqli_fetch_assoc($resultado_favorito);
                                    $id_user_favorito = $array_3['ID_uti'];
                                    $id_star = $id_user_favorito . '' . $id_cont . '' . $id_form;
                            ?>
                                    <div class="area_star">
                                        <img src="./img/icons/StarRatings_Yellow.svg" alt="" width="17" height="17" class="int" id=<?php echo  $id_star; ?> onclick="addLista(<?php echo  $id_cont; ?>,<?php echo $id_form; ?>,<?php echo   $id_user_favorito; ?>,<?php echo  $id_star; ?> )">
                                    </div>
                                    <?php

                                    //$conn->close();
                                } else {
                                    $sql_id_favorito = "SELECT users.ID_uti FROM utilizador AS users WHERE users.Username = '$username'";

                                    $resultado_id_favorito = mysqli_query($conn, $sql_id_favorito);

                                    if ($resultado_id_favorito->num_rows > 0) {

                                        $array_3 = mysqli_fetch_assoc($resultado_id_favorito);
                                        $id_user_favorito = $array_3['ID_uti'];
                                        $id_star = $id_user_favorito . '' . $id_cont . '' . $id_form;

                                    ?>
                                        <div class="area_star">
                                            <img src="img/icons/StarRatings.svg" alt="" width="17" height="17" class="int" id=<?php echo  $id_star; ?> onclick="addLista(<?php echo  $id_cont; ?>,<?php echo $id_form; ?>,<?php echo  $id_user_favorito; ?>,<?php echo  $id_star; ?>)">
                                        </div>
                            <?php
                                    } else {
                                        echo "erro lista";
                                        $conn->close();
                                    }
                                    //$conn->close();
                                }
                            } else {
                                echo "erro ao carregar dados de base de dados lista";
                                $conn->close();
                            }
                            ?>

                            <div style="display: flex; font-size: 13px;">
                                <p class="views" style="margin:8.5px 5px 0px 0px;">
                                    <?php echo $array[$ic]['vizualizacao']; ?></p> <img class="views" src="img/icons/EyePasswordShow.svg" alt="Visualizações" width="17" height="17" style="margin-top: 8px">
                            </div>
                        </div>

                    </div>
                <?php

                } ?>

            </div>

        </div>

    </div>

    <footer class="rodape">
        <p class="paragrafo">
            <a href="#" id="cor">Cookies</a>
        </p>
        <p class="paragrafo">
            <a href="#" id="cor">Políticas de Privacidade</a>
        </p>
        <p class="paragrafo">
            <a href="#" id="cor">Termos e Condições</a>
        </p>
        <p class="paragrafo" id="ulti">
            <a href="#" id="cor">&copy; 2020 Ministério de Cultura &amp; UniPiaget</a>
        </p>
    </footer>

    <script>
        function mudaIcon(cont, form, id_user, id, id_like) {

            $.ajax({
                url: 'config.php',
                type: 'POST',
                data: {
                    cont: cont,
                    form: form,
                    id_user: id_user
                },
                success: function(result1) {
                    // Retorno se tudo ocorreu normalmente
                    //console.log(result1);
                    if (result1 == 1) {
                        //document.write('retornou sim');
                        //console.log("true");
                        // console.log(result1);
                        document.getElementById(id).src = "img/icons/HeartLoveLike_Orange.svg";
                        var likes = document.getElementById(id_like).innerText;
                        //alert(likes);
                        var dados = JSON.stringify(document.getElementById(id_like).innerHTML = --likes);
                        //alert(dados);
                        $.ajax({
                            url: 'deleteLikes.php',
                            type: 'POST',
                            data: {
                                data: dados,
                                cont: cont,
                                form: form,
                                id_user: id_user
                            },
                            success: function(result_1) {
                                // Retorno se tudo ocorreu normalmente
                                //document.write(result);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                // Retorno caso algum erro ocorra
                            }
                        });
                    } else {
                        //document.write(result);
                        //console.log("false");
                        //console.log(result1);
                        document.getElementById(id).src = "img/icons/HeartLoveLike_Filled.svg";
                        var curtidas = document.getElementById(id_like).innerText;
                        //alert(curtidas);
                        var dados = JSON.stringify(document.getElementById(id_like).innerHTML = ++curtidas);
                        //alert(dados);
                        $.ajax({
                            url: 'saveLikes.php',
                            type: 'POST',
                            data: {
                                data: dados,
                                cont: cont,
                                form: form,
                                id_user: id_user
                            },
                            success: function(result_1_1) {
                                // Retorno se tudo ocorreu normalmente
                                //document.write(result);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                // Retorno caso algum erro ocorra
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Retorno caso algum erro ocorra
                }

            });
            //console.log(result);
            //console.log("Ponto1");
        }

        function alerta(id_cont, id_form, id_user) {
            /*alert(id_cont);
            alert(id_form);
            console.log(id_cont);
            console.log(id_form);
            console.log(id_user);*/
            $.ajax({
                url: 'CreateSession.php',
                type: 'POST',
                data: {
                    id_cont: id_cont,
                    id_form: id_form,
                    id_user: id_user
                },
                success: function(resul) {
                    // Retorno se tudo ocorreu normalmente
                    //document.write(result);
                    //alert(result);
                    //console.log(resul);
                    if (id_form == 3) {
                        window.location.href = "visualiza_video.php";
                    } else if (id_form == 2) {
                        window.location.href = "visualizar_audio.php";
                    } else if (id_form == 1) {
                        window.location.href = "visualizar_texto.php";
                    } else {
                        document.write('err');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Retorno caso algum erro ocorra
                    //document.write(' Retorno caso algum erro ocorra');
                }
            });
        }

        function addLista(cont, form, id_user, id_fvr) {

            /*alert('entrou');
            console.log(cont);
            console.log(form);
            console.log(id_user);
            console.log(id_fvr);*/

            $.ajax({
                url: 'Fav.php',
                type: 'POST',
                data: {
                    cont: cont,
                    form: form,
                    id_user: id_user
                },
                success: function(result3) {
                    // Retorno se tudo ocorreu normalmente
                    //console.log(result3);
                    if (result3 == 1) {
                        document.getElementById(id_fvr).src = "img/icons/StarRatings.svg";
                        $.ajax({
                            url: 'deleteListaFavoritos.php',
                            type: 'POST',
                            data: {
                                cont: cont,
                                form: form,
                                id_user: id_user
                            },
                            success: function(result_3) {
                                // Retorno se tudo ocorreu normalmente
                                //document.write('Retorno se tudo ocorreu normalmente delete');
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                // Retorno caso algum erro ocorra
                                //document.write('Retorno caso algum erro ocorra');
                            }
                        });
                    } else {
                        document.getElementById(id_fvr).src = "./img/icons/StarRatings_Yellow.svg";
                        $.ajax({
                            url: 'saveListaFavoritos.php',
                            type: 'POST',
                            data: {
                                cont: cont,
                                form: form,
                                id_user: id_user
                            },
                            success: function(result_3_3) {
                                // Retorno se tudo ocorreu normalmente
                                //document.write('Retorno se tudo ocorreu normalmenten save');
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                // Retorno caso algum erro ocorra
                                //document.write('Retorno caso algum erro ocorra');
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Retorno caso algum erro ocorra
                }

            });
            //console.log(result);
            //console.log("Ponto1");
        }
    </script>

    <script>
        var modal = document.getElementById("myModal");
        var modalConf = document.getElementById("myModalConf");

        function cancelar() {
            modal.style.display = "none";
            modalConf.style.display = "none";

            document.getElementById('ficheiro').value = '';
            document.getElementById('titulo').value = '';
            document.getElementById('produtor').value = '';
            document.getElementById('autor').value = '';
            document.getElementById('dataProducao').value = '';
            document.getElementById('tipoC').value = '';
        }

        function adcionar() {
            modal.style.display = "block";
            modalConf.style.display = "none";
        }

        function guardar() {

            var formularido = document.getElementById('formulario');

            formularido.addEventListener('submit', function(e) {

                modal.style.display = "none";
                modalConf.style.display = "block";

                // impede o envio do form*/
                e.preventDefault();
            });
        }

        function sim() {
            console.log('clicou sim');

            var ficheiro = document.getElementById('ficheiro').value;
            var tituloC = document.getElementById('titulo').value;
            var produtorC = document.getElementById('produtor').value;
            var autorC = document.getElementById('autor').value;
            var dataProd = document.getElementById('dataProducao').value;
            var categoria = $('#tipoC :selected').val();
            var tipo_uti_atual = <?php echo $tipo_uti_atual; ?>

            AdCont(ficheiro, tituloC, produtorC, autorC, dataProd, categoria, tipo_uti_atual);
        }

        function nao() {
            console.log('clicou no');
            cancelar();
        }

        function AdCont(ficheiro, tituloC, produtorC, autorC, dataProd, categoria, tipo_uti_atual) {

            modalConf.style.display = "none";
            modal.style.display = "none";

            $.ajax({
                url: 'CreateCont.php',
                type: 'POST',
                data: {
                    ficheiro: ficheiro,
                    tituloC: tituloC,
                    produtorC: produtorC,
                    autorC: autorC,
                    dataProd: dataProd,
                    categoria: categoria,
                    tipo_uti_atual: tipo_uti_atual
                },
                success: function(re) {
                    // Retorno se tudo ocorreu normalmente
                    console.log(re);

                    switch (re) {

                        case '1':
                            window.location.href = "TelaInicial.php";
                            break;
                        case '2':
                            alert('Lamentamos mas as extensões permitidas são pdf/mp3/mp4!!');
                            break;
                        case '3':
                            alert('Lamentamos mas esse conteúdo já se encontra na aplicação!!');
                            break;
                        case '4':
                            alert('Lamentamos mas esse produtor não se encontra registado na aplicação!!');
                            break;
                        case '5':
                            alert('Lamentamos mas esse ficheiro já se encontra registado na aplicação!!');
                            break;
                        default:
                            alert('Erro ao adicionar conteúdo!!!');
                            break;
                    }
                    cancelar();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Retorno caso algum erro ocorra
                    //document.write(' Retorno caso algum erro ocorra');
                }
            });
        }

        window.onclick = function(event) {
            if (event.target == modal || event.target == modalConf) {
                modal.style.display = "none";
                modalConf.style.display = "none";
            }
        }
    </script>

</body>

</html>