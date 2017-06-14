<?php 
	include 'server/conexao.php';
	include 'server/funcoes_cest.php';
	@session_start();

	$sql_ncm = "SELECT ID_NCM, 
					   NCM,
					   QTD_REGISTRO,
					   AJUSTADO,
					   CPF_CNPJ 
				  FROM TBL_NCM
				 WHERE AJUSTADO = 'N'
			  ORDER BY ID_NCM";
	$exe_ncm = odbc_exec($db_consulta, $sql_ncm);
	while ( $linha = odbc_fetch_object($exe_ncm) ) {
		// 'CONTAGEM' => $linha->CONTAGEM,
		$lista_ncm[] = array(
			'ID_NCM' => $linha->ID_NCM,
			'NCM' => $linha->NCM,
			'QTD_REGISTRO' => $linha->QTD_REGISTRO,
			'AJUSTADO' => $linha->AJUSTADO,
			'CPF_CNPJ' => $linha->CPF_CNPJ,
		);
	}
	echo json_encode( $lista_ncm ) ;
?>