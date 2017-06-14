<?php 
	include '../server/conexao.php';

	odbc_exec($db_consulta, "DELETE FROM TBL_IBPTAX");

	$sql_ibptax = "SELECT NCM_IBPTX, NOME_NCM_IBPTAX FROM TBL_IBPTAX";
	$exe_ibptax = odbc_exec($db_cliente, $sql_ibptax);
	$inseridos = true;
	while (odbc_fetch_row($exe_ibptax)) {
		$NCM       = odbc_result($exe_ibptax, 'NCM_IBPTX');
		$DESCRICAO = odbc_result($exe_ibptax, 'NOME_NCM_IBPTAX');

		$sql_insert_ibptax = "INSERT INTO TBL_IBPTAX (NCM_IBPTAX,
													  NOME_NCM_IBPTAX
													 )
											  VALUES ('$NCM',
										  			  '$DESCRICAO'
										  			 )";
		$exe_insert_ibptax = odbc_exec($db_consulta, $sql_insert_ibptax);
		echo $sql_insert_ibptax;
		if (!$exe_insert_ibptax){
			$inseridos = false;
			break;
		}

	}
	$resultado[] = array('resultado' => $inseridos, );
	echo json_encode($resultado);

?>