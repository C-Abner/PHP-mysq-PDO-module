<?php
	include_once htmlspecialchars($_SERVER['DOCUMENT_ROOT'])."/mysqldb.php";
	include_once htmlspecialchars($_SERVER['DOCUMENT_ROOT'])."/conf_sql.php";

	$db = new mysqldb();

	# select sample
	$sql = "SELECT * WHERE id=? and flg=? ";
	$params[] = array( $_SESSION["id"], PDO::PARAM_STR );
	$params[] = array( "1", PDO::PARAM_STR );
	$rec = $db->getfirst($sql, $params);
	//$rec = $db->getall($sql, $params);
	$params = null;

	# delete sample ( update is same of this)
	$sql = "DELETE FROM `test` WHERE id=? AND flg=?";
	$params[] = array( $_SESSION["login_bid"], PDO::PARAM_STR );
	$params[] = array( $flg , PDO::PARAM_STR );
	$db->execute( $sql, $params );
	$params = null;
?>
