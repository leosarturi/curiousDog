<?php

require './seguranca.php';
require './conexao.php';
if(isset($_POST['idresposta']) && isset($_COOKIE['idusuario'])){
    $executa = $db->prepare("call descurtir(:a,:b)");
    $executa->BindParam(":a",$_POST['idresposta']);
    $executa->BindParam(":b",$_COOKIE['idUsuario']);
    $executa->execute();
    if($executa){
       
       echo "sucesso";
    }

}