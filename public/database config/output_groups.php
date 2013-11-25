<?php

require 'config.php';



$value = $_GET['Groups'];
if($value == 'Groups'){

	try {
	     $dbh = new PDO('mysql:host=localhost;dbname=websysfinaldatabase', $config['DB_USERNAME'], $config['DB_PASSWORD']);
	     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    echo 'Connected to database<br />';

	    $stmt = $dbh->prepare("SELECT * FROM `group` ORDER BY `groupnumber`");

	    $stmt->execute();


	    $result = $stmt->fetchAll();

	    foreach($result as $row)
	        {
	        echo $row['rcs'].': group ';
	        echo $row['groupnumber'].'<br />';
	        }


	    $dbh = null;
	}
	catch(PDOException $e)
	    {
	    echo $e->getMessage();
	    }
	}




?>