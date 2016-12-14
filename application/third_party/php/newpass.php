#!/usr/bin/php
<?php
if (isset($argv[1])) {
	$pass=trim($argv[1]);
		
	$pdo = new PDO('mysql:host=127.0.0.1;dbname=ps', 'ps', 'xeniak!6hL');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$statement = $pdo->query("UPDATE users SET password='".md5($pass)."' WHERE username='admin'");
} else {
	die ("Give password to set for user admin!");
}
?>