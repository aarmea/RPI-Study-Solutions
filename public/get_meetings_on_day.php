<?php

  require_once "db/init.php";
  require 'db/config.php';
  require_once "auth/cas_init.php";
  require_once "classes/user.php";
  require_once "classes/group.php";

  global $db;
  require_once "login.php";
  
  $userid = $client->username();

  $year = $_POST['hyear'];
  $month = $_POST['hmonth'];
  $day = $_POST['hday'];

  //Query for all meetings on this day

  //echo "$userid $year $month $day";

  //$query = $db->prepare("SELECT DISTINCT * FROM group_members INNER JOIN group_meetings ON group_meetings.groupid=group_members.groupid WHERE rcsid=:userid AND year=:year AND month=:month AND day=:day");

  //$query->execute(array(":userid"=>$userid,"year"=>$year,"month"=>$month,"day"=>$day));

  $query = $db->prepare("SELECT DISTINCT * FROM group_members INNER JOIN group_meetings ON group_meetings.groupid=group_members.groupid WHERE rcsid=:userid AND year=:year  AND month=:month AND day=:day");

  $query->execute(array(":userid"=>$userid,"year"=>$year,"month"=>$month,"day"=>$day));

  $result = $query->fetchAll();

  //echo var_dump($result);

  foreach($result as $item)
  {
    echo $item->name . " @ " . $item->hour . ":00" . "<br>";
  }
  if(count($result) == 0)
  {
    echo "No meetings on this day";
  }

  //echo "blah";

?>