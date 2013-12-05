<?php 

require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";
require_once "login.php";

$group = new Group($_GET["g"]);
$month=$_POST["month"];
$month=date('m',strtotime($month));
$day=$_POST["day"];
$year=$_POST["year"];
$day=$_POST["day"];
$hour=$_POST['time'];
$name=$_POST['eventName'];
//validate date
$date = new DateTime();
$date->setDate ( $year , $month , $day );
$date->setTime ( $hour , 0, 0 );
$now = new DateTime;
$now->setTimeStamp($_SERVER['REQUEST_TIME']);

//echo var_dump($date);
//echo var_dump($now);

$valiDate=checkdate($month,$day,$year);
if(!isset($name) || $name == "")
  $msg="Please enter in an event name";
else if(!isset($hour))
  $msg="Hour not set";
else if(!$valiDate)
  $msg="Invalid date entered";
else if($now > $date)
  $msg="Date has already passed";
else
{
  $msg="Meeting successfuly scheduled";
  
  $query=$db->prepare("INSERT INTO `group_meetings` (`groupid`, `name`, `year`,`month`,`day`,`hour`,`min`)
    VALUES (:groupid, :name, :year,:month,:day,:hour,:min)");
      $query->execute(array(':groupid'=>$group->id(),
                            ':name'=>$name,
                            ':year'=>$year,
                            ':month'=>$month,
                            ':day'=>$day,
                            ':hour'=>$hour,
                            ':min'=>0));
                            
}
echo $msg;


?>