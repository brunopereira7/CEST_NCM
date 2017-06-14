<?php
	function conecta_odbc($DBNAME){
		$Driver = "Firebird/InterBase(r) driver;";
		$UID    = "SYSDBA;";
		$PWD    = "masterkey";
		return odbc_connect("DRIVER=".$Driver."UID=".$UID."PWD=".$PWD."; DBNAME=".$DBNAME, "ADODB.Connection", "");
	}
	function conectaBanco($idBanco){
		date_default_timezone_set('America/Campo_Grande');
		if ($idBanco == 1) {
			// banco de dados consulta cest
			$conn = conecta_odbc("C:\RCK\BANCOS\CEST\DB_CEST.RCK");
		}elseif ($idBanco == 2){
			// banco de dados do cliente
			$conn = conecta_odbc("C:\RCK\BANCOS\CEST\DB_CLIENTE.RCK");
		}
		return $conn;
	}
	$db_consulta = conectaBanco(1);
	$db_cliente  = conectaBanco(2);
?>