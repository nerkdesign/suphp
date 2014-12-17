<?php
/*
Script de creation de la table en base de donnée

Pour la jouer, remplacez les valeurs dans le script puis jouer le en faisant : #php5 ./creationbase.php

A remplacer :
serveur.sql : ip ou nom du serveur mysql
user : utilisateur mysql
sesame : son mot de passe
base_sql : nom de la base sql a utiliser
*/

mysql_connect("serveur.sql", "user", "sesame") or die(mysql_error());
	mysql_select_db("base_sql") or die(mysql_error());

	mysql_query("CREATE TABLE supervision (
		id INT AUTO_INCREMENT,
		nom TEXT,
		ip TEXT,
		url TEXT,
		t_ssh INT,
		t_url INT,
		t_ping INT,
	        r_ssh INT,
		r_url INT,
		r_ping INT,
		sms INT
	  PRIMARY KEY(id)
	)") Or die(mysql_error());
	mysql_close ();
	
?>
