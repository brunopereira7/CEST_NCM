<?php 
	include 'server/conexao.php';

	$sql_deleta = "DELETE FROM TBL_NCM";
	$exe_deleta = odbc_exec($db_consulta, $sql_deleta);

	$sql_deleta_update = "DELETE FROM TBL_UPDATE";
	$exe_deleta_update = odbc_exec($db_consulta, $sql_deleta_update);
	
	$set_generator = odbc_exec($db_consulta, "SET GENERATOR GEN_ID_NCM TO 0");
	$set_generator2 = odbc_exec($db_consulta, "SET GENERATOR GEN_ID_UPDATE TO 0");

	$acao = ($exe_deleta && $exe_deleta_update) ? true : false ;

	$resultado[] = array('resultado' => $acao, );
	echo json_encode( $resultado ) ;


?>