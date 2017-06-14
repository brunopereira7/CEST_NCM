<?php 
	function insertNCM(){
		include 'server/conexao.php';

		$sql_ncm = "SELECT COUNT(P.ID_PRODUTO) AS CONTAGEM, 
						   P.NCM,
						   N.DESCRICAO_NCM
					  FROM TBL_PRODUTO P
				 LEFT JOIN TBL_NCM N
						ON P.NCM = N.NCM 
					 WHERE P.CEST IS NULL 
					   AND P.NCM IS NOT NULL
				  GROUP BY P.NCM,
				  		   N.DESCRICAO_NCM
				  ORDER BY CONTAGEM DESC";
		$exe_ncm = odbc_exec($db_cliente, $sql_ncm);

		$sql_empresa = odbc_exec($db_cliente, "SELECT CNPJ FROM TBL_EMPRESA WHERE ID_EMPRESA = 1");

		if ($sql_empresa) {
			$cnpj = odbc_result($sql_empresa, "CNPJ");
		}else{
			$cnpj = 'erro_000000000';
		}


		$inseridos = true;

		while (odbc_fetch_row($exe_ncm)) {
			$NCM 		   = odbc_result($exe_ncm, "NCM");
			$QTD_REGISTRO  = odbc_result($exe_ncm, "CONTAGEM");
			$DESCRICAO_NCM = (odbc_result($exe_ncm, "DESCRICAO_NCM") != null) ? odbc_result($exe_ncm, "DESCRICAO_NCM") : '' ;
			if (strlen($NCM) == 8) {
				# code...
				$ncm_array = str_split($NCM);
				$ncm_2 = $ncm_array[0] . $ncm_array[1];
				$ncm_3 = $ncm_2 . $ncm_array[2];
				$ncm_4 = $ncm_3 . $ncm_array[3];
				$ncm_5 = $ncm_4 . $ncm_array[4];
				$ncm_6 = $ncm_5 . $ncm_array[5];
				$ncm_7 = $ncm_6 . $ncm_array[6];
				$ncm_8 = $ncm_7 . $ncm_array[7];

				$sql_repetido = "SELECT ID_CEST,
										CEST
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
				$num_resultado = odbc_num_rows($exe_repetido);
				if ( $num_resultado > 0) {
					switch ($num_resultado) {
						case 1:
							$CEST_PRINCIPAL = odbc_result($exe_repetido, 'CEST');
							$AJUSTADO       = 'S';
							break;
						
						default:
							$CEST_PRINCIPAL = '';
							$AJUSTADO       = 'N';
							break;
					}

					$DATABASE      = ' RDB$DATABASE';
					$sql_generator = "SELECT GEN_ID(GEN_ID_NCM,1) AS NOVO_ID FROM $DATABASE";
					$exe_generator = odbc_exec($db_consulta, $sql_generator);
					$id_ncm 	   = odbc_result($exe_generator, 'NOVO_ID');
			
					$sql_insert = "INSERT INTO TBL_NCM ( ID_NCM,
														 NCM,
														 QTD_REGISTRO,
														 CPF_CNPJ,
														 CEST_PRINCIPAL,
														 AJUSTADO,
														 DESCRICAO_NCM
													   )
												VALUES ( $id_ncm,
														 '$NCM',
														 $QTD_REGISTRO,
														 '$cnpj',
														 '$CEST_PRINCIPAL',
														 '$AJUSTADO',
														 '$DESCRICAO_NCM'
														)";
					$exe_insert = odbc_exec($db_consulta, $sql_insert);
					
					$result_insert = ($exe_insert) ? true : false;

					if ($result_insert && $AJUSTADO == 'S'){						

						$sql_insere = "INSERT INTO TBL_UPDATE ( 
																NCM,
																CEST,
																ID_NCM
															  )
													   VALUES (
																'$NCM',
																'$CEST_PRINCIPAL',
																$id_ncm
													   		  )";
						$exe_insere = odbc_exec($db_consulta, $sql_insere);
					}elseif (!$result_insert){
						$inseridos = false;
						break;
					}
				}
			}
		}
		return $inseridos;

	}
?>