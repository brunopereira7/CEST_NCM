<?php 
	include 'server/conexao.php';
	include 'server/funcoes.php';
	$ncm = addslashes($_REQUEST['NCM']);
	// $ncm = '73181500';
	$NCM_ORIGINAL = $ncm;
	$ncm = str_split($ncm);
	$ncm_2 = $ncm[0] . $ncm[1];
	$ncm_3 = $ncm_2 . $ncm[2];
	$ncm_4 = $ncm_3 . $ncm[3];
	$ncm_5 = $ncm_4 . $ncm[4];
	$ncm_6 = $ncm_5 . $ncm[5];
	$ncm_7 = $ncm_6 . $ncm[6];
	$ncm_8 = $ncm_7 . $ncm[7];

	$sql_repetido = "SELECT ID_CEST,
							NCM,
							CEST,
							DESCRICAO,
							SEGMENTO
					   FROM TBL_CEST 
					  WHERE NCM = '".$ncm_2."'
						 OR NCM = '".$ncm_3."'
						 OR NCM = '".$ncm_4."'
						 OR NCM = '".$ncm_5."'
						 OR NCM = '".$ncm_6."'
						 OR NCM = '".$ncm_7."'
						 OR NCM = '".$ncm_8."'
					";
	$exe_repetido = odbc_exec($db_consulta, $sql_repetido);
	$sql_ncm = "SELECT DESCRICAO_NCM FROM TBL_NCM WHERE NCM = '".$NCM_ORIGINAL."'";
	$exe_ncm = odbc_exec($db_consulta, $sql_ncm);
	$DESCRICAO_NCM = (odbc_result($exe_ncm, "DESCRICAO_NCM") != null) ? string_db_to_upper(odbc_result($exe_ncm, "DESCRICAO_NCM")) : 'Sem descrição';
	for ($i=0; $tupla = odbc_fetch_object($exe_repetido) ; $i++) {
		// 'CONTAGEM' => $linha->CONTAGEM,
		if ($i == 1) {
			$DESCRICAO_NCM = '';
		}
		$lista_cest[] = array(
			'ID_CEST' => $tupla->ID_CEST,
			'NCM' => $tupla->NCM,
			'CEST' => $tupla->CEST,
			'NCM_ORIGINAL' => $NCM_ORIGINAL,
			'DESCRICAO' => string_db_to_upper($tupla->DESCRICAO),
			'SEGMENTO' => string_db_to_upper($tupla->SEGMENTO),
			'DESCRICAO_NCM' => $DESCRICAO_NCM,
		);
	}
	echo json_encode( $lista_cest ) ;
?>