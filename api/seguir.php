<?php 
	require '/var/task/user/api/seguranca.php';
	require '/var/task/user/api/conexao.php';

	if(isset($_POST['usuario']) && isset($_POST['follow'] )){
		$executa = $db->prepare(" INSERT INTO seguindo (usuario, follow) VALUES(:usuario, :follow)");
		$executa->BindParam(":usuario", $_POST['usuario']);
		$executa->BindParam(":follow", $_POST['follow']);
		$executa->execute();

		IF($executa) echo 'succes';

	}

	
?>