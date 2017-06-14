<?php 
	include 'server/conexao.php';

	$ID_NCM = addslashes($_REQUEST['ID_NCM']);
	$CEST   = addslashes($_REQUEST['CEST']);

	$sql_ncm = "UPDATE TBL_NCM SET CEST_PRINCIPAL = '$CEST', AJUSTADO = 'S' WHERE ID_NCM = ".$ID_NCM;
	$exe_ncm = odbc_exec($db_consulta, $sql_ncm);
	if ($exe_ncm) {
		$sql_insert = "INSERT INTO TBL_UPDATE ( CEST,
												ID_NCM,
												MANUAL
											  )
									   VALUES ('$CEST',
												$ID_NCM,
												'S'
											   )";
		$sql_insert = odbc_exec($db_consulta, $sql_insert);
	}

	$resultado = ($exe_ncm) ? true : false ;

	$ajustado[] = array('resultado' => $resultado, );
	echo json_encode($ajustado);

?>