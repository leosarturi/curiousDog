<?php
require 'seguranca.php';
	require 'conexao.php';

	if(isset($_POST['usuario']) && isset($_POST['mensagem'] ) && isset($_POST['anom'])){
        if($_POST['anom']=="true"){
            $ba=1;
        }else if($_POST['anom'] == "false"){
            $ba=0;

        }
		$executa = $db->prepare(" INSERT INTO pergunta (mensagem,remetente,destinatario,anonimo) VALUES(:m, :r,:d,:a)");
		$executa->BindParam(":d", $_POST['usuario']);
		$executa->BindParam(":m", $_POST['mensagem']);
        $executa->BindParam(":r", $_COOKIE['idusuario']);
        $executa->BindParam(":a", $ba);
		$executa->execute();

		IF($executa) echo 'succes';

	}

    ?>