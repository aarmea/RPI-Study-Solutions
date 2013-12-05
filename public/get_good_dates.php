<?php

  require_once "db/init.php";
  require 'db/config.php';
  require_once "auth/cas_init.php";
  require_once "classes/user.php";
  require_once "classes/group.php";

  global $db;
  require_once "login.php";
  
  $group = new Group($_GET["g"]);

  $year = $_POST['year'];
  $month = $_POST['month'];
  $day = $_POST['day'];

  $good_hours = array();
  foreach ($group->members() as $key => $value) {
    $dbh = $db->prepare("SELECT year,month,hour,day FROM available_times WHERE rcsid=:rcsid");
    $dbh->execute(array(":rcsid" => $key));
    $result = $dbh->fetchAll();
    foreach($result as $row)
    {
      for($i=0;$i<24;$i++)
      {
        //echo "$year," . (string)($month - 1) . ",$day,$i<br>";
        //echo "$row->year,$row->month,$row->day,$row->hour<br><br>";
        if($year == $row->year && ((string)($month-1)) == $row->month && $day == $row->day && (string)$i == $row->hour)
        {
          array_push($good_hours,$i);
          //echo "$year," . (string)($month - 1) . ",$day,$i<br>";
          //echo "$row->year,$row->month,$row->day,$row->hour<br><br>";
        }
      }
    }
  }

  for($i=0;$i<24;$i++)
  {
    if(in_array($i,$good_hours))
    {
      echo "<option value=$i style='color:lightgreen'>" . date('h.iA', strtotime("$i:00")) . "</option>";
    }
    else
    {
      echo "<option value=$i style='color:red'>" . date('h.iA', strtotime("$i:00")) . "</option>";
    }
  }

  //foreach($good_hours as $i)
  //  echo "<option value=$i>" . date('h.iA', strtotime("$i:00")) . "</option>";

  echo "Pass";
?>