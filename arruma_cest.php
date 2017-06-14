<?php 
	include 'server/conexao.php';
	$db_consulta;
	$sql_cest = "SELECT ID_CEST,
						CEST
				   FROM TBL_CEST";
	$exe_cest = odbc_exec($db_consulta, $sql_cest);
	echo "<table>";
	echo "	<tr>";
	echo "		<th>id</th>";
	echo "		<th>CEST Antigo</th>";
	echo "		<th>CEST Novo</th>";
	echo "	</tr>";
	while (odbc_fetch_row($exe_cest)) {
		# code...
		$id_cest  = odbc_result($exe_cest, "ID_CEST");
		$cod_cest = odbc_result($exe_cest, "CEST");
		if ( strlen($cod_cest) == 6 ) {
			# code...
			$novo_cest = '0'.$cod_cest;
			$sql_update = "UPDATE TBL_CEST SET CEST = '$novo_cest' WHERE ID_CEST = ".$id_cest;
			$exe_update = odbc_exec($db_consulta, $sql_update);
			echo "	<tr>";
			echo "		<td>".$id_cest."</td>";
			echo "		<td>".$cod_cest."</td>";
			echo "		<td>".$novo_cest."</td>";
			echo "	</tr>";
		}
	}
	echo "</table>";
?>