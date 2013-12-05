<?php

  require_once "db/init.php";
  require 'db/config.php';
  require_once "auth/cas_init.php";
  require_once "classes/user.php";

  global $db;
  require_once "login.php";
  $rcsid = $client->username();

  $error = false;

  if(isset($_POST['dates']))
  {
    //echo "Got the post<br>";
    //echo "its value is " . $_POST['dates'] . '<br>';
  }

  $times = json_decode(stripslashes($_POST['dates']));

  if(!is_array($times))
  {
      echo "<p style='error'>Error: Not an array</p>";
  }

  if(!isset($_POST['email']) || $_POST['email'] == '')
  {
    echo "<p style='error'>Please enter in an email</p>";
    $error = true;
  }
  else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
  {
    echo "<p style='error'>Email not in proper form</p>";
    $error = true;
  }
  
  if(isset($_POST['rem_set_1']))
  {
  }
  if(isset($_POST['rem_set_2']))
  {
  }
  if(isset($_POST['rem_set_3']))
  {
  }

  if(!$error)
  {
    //Sanatize the email
    $s_email = $_POST['email'];

    //Do database stuff here
    $dbh = $db->prepare("UPDATE users SET email=:email WHERE rcsid=:rcsid");
    $dbh->execute(array(":email" => $s_email, ":rcsid" => $rcsid));

    $dates = array();

    $dbh = $db->prepare("DELETE FROM available_times WHERE rcsid=:rcsid");
    $dbh->execute(array(":rcsid" => $rcsid));
      
    for($i=0;$i<count($times);$i++)
    {
      $date = new DateTime();
      $date->setDate ( $times[$i][0] , $times[$i][1] , $times[$i][2] );
      $date->setTime ( $times[$i][3] , 0, 0 );
      array_push($dates,$date);
      
      //echo $date->format(DateTime::ISO8601) . '<br>';

      $dbh = $db->prepare("INSERT INTO available_times VALUES(?,?,?,?,?)");
      
      $dbh->bindParam(1,$rcsid);
      $dbh->bindParam(2,$times[$i][0]);
      $dbh->bindParam(3,$times[$i][1]);
      $dbh->bindParam(4,$times[$i][2]);
      $dbh->bindParam(5,$times[$i][3]);

      $dbh->execute();

    }

    echo "<p style='success'>Your settings have been saved.</p>";
  }
?>