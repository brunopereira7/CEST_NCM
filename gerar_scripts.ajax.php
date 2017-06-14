<?php 
	include 'server/conexao.php';
	$sql_ncm = "SELECT N.NCM,
					   U.CEST
				  FROM TBL_UPDATE U
				  JOIN TBL_NCM N
					ON N.ID_NCM = U.ID_NCM
			  ORDER BY ID_UPDATE DESC";
	$exe_ncm = odbc_exec($db_consulta, $sql_ncm);

	while ( odbc_fetch_row($exe_ncm) ) {
		$CEST = odbc_result($exe_ncm, 'CEST');
		$NCM  = odbc_result($exe_ncm, 'NCM');
		$update = "UPDATE TBL_PRODUTO SET CEST = '$CEST' WHERE NCM = '$NCM';";

		$updates_gerados[] = array('UPDATE' => $update,);
	}
	echo json_encode($updates_gerados);
?>