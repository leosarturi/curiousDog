<?php
require 'seguranca.php';
require 'conexao.php';


if(isset($_POST['idresposta']) && isset($_COOKIE['idusuario'])){
    $executa = $db->prepare("INSERT INTO respostacurtida(resposta,usuario) VALUES(:idresp, :idusu)");
    $executa->BindParam(":idresp", $_POST['idresposta']);
    $executa->BindParam(":idusu", $_COOKIE['idusuario']);
    $executa->execute();
    if($executa){
        echo "sucesso";
    }
}