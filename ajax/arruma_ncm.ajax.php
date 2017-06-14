<?php 
	include '../server/conexao.php';

	$sql_deleta = "DELETE FROM TBL_NCM";
	$exe_deleta = odbc_exec($db_cliente, $sql_deleta);
	$inseridos  = true;
	if ($exe_deleta) {
		$sql_insert = "INSERT INTO TBL_NCM (NCM, DESCRICAO_NCM) SELECT NCM_IBPTX, NOME_NCM_IBPTAX FROM TBL_IBPTAX";
		$exe_insert = odbc_exec($db_cliente, $sql_insert);
		if (!$exe_insert) {
			$inseridos = false;
		}
	}else{
		$inseridos = false;
	}

	$resultado[] = array('resultado' => $inseridos, );
	echo json_encode($resultado);

?>