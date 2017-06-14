<?php 
	include '../server/funcoes_cest.php';

	$importados = insertNCM();

	$importados = ($importados) ? true : false ;
	
	$resultado[] = array('resultado' => $importados, );
	echo json_encode( $resultado ) ;

?>