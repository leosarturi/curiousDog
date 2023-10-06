<?php
	require '/var/task/user/api/seguranca.php';
	require '/var/task/user/api/conexao.php';
	

	$executa = $db->prepare("UPDATE usuario SET bio=:bio where idusuario=:idusuario");
	$executa->BindParam(":bio", $_POST['bio']);	
	$executa->BindParam(":idusuario", $_SESSION['idUsuario']);
	$executa->execute();
	

	?>