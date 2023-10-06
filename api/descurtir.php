<?php

require '/var/task/user/api/seguranca.php';
require '/var/task/user/api/conexao.php';
if(isset($_POST['idresposta']) && isset($_SESSION['idUsuario'])){
    $executa = $db->prepare("call descurtir(:a,:b)");
    $executa->BindParam(":a",$_POST['idresposta']);
    $executa->BindParam(":b",$_SESSION['idUsuario']);
    $executa->execute();
    if($executa){
       
       echo "sucesso";
    }

}