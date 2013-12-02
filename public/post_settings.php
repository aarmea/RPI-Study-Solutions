<?php

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

  $dates = array();

  for($i=0;$i<count($times);$i++)
  {
    $date = new DateTime();
    $date->setDate ( $times[$i][0] , $times[$i][1] , $times[$i][2] );
    $date->setTime ( $times[$i][3] , 0, 0 );
    array_push($dates,$date);
    echo $date->format(DateTime::ISO8601) . '<br>';
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
    //Do database stuff here
    echo "<p style='success'>Your settings have been saved.</p>";
  }
?>