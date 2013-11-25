<?php

require 'config.php';



$value = $_GET['Users'];
if($value == 'Users'){

	try {
	     $dbh = new PDO('mysql:host=localhost;dbname=websysfinaldatabase', $config['DB_USERNAME'], $config['DB_PASSWORD']);
	     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    echo 'Connected to database<br />';

	    $stmt = $dbh->prepare("SELECT * FROM user ORDER BY lname");

	    $stmt->execute();


	    $result = $stmt->fetchAll();

	    foreach($result as $row)
	        {
	        echo $row['rcs'].' ';
	        echo $row['fname'].' ';
	        echo $row['lname'].'<br />';
	        }


	    $dbh = null;
	}
	catch(PDOException $e)
	    {
	    echo $e->getMessage();
	    }
	}




?>