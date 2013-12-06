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
$location=$_POST['location'];
//validate date
$date = new DateTime();
$date->setDate ( $year , $month , $day );
$date->setTime ( $hour , 0, 0 );
$now = new DateTime;
$now->setTimeStamp($_SERVER['REQUEST_TIME']);

//echo var_dump($date);
//echo var_dump($now);
$msg='';
$valiDate=checkdate($month,$day,$year);
if(!isset($name) || $name == "")
  $msg.="<li>Please enter an event name</li>";
if(!isset($location) || $location == "")
  $msg.="<li>Please enter a location for the event</li>";
if(!isset($hour))
  $msg.="<li>Hour not set</li>";
if(!$valiDate)
  $msg.="<li>Invalid date entered</li>";
if($now > $date)
  $msg.="<li>Date has already passed</li>";
if($msg=='')
{
  $msg="Meeting successfuly scheduled";
  
  $query=$db->prepare("INSERT INTO `group_meetings` (`groupid`, `name`, `year`,`month`,`day`,`hour`,`location`)
    VALUES (:groupid, :name, :year,:month,:day,:hour,:location)");
      $query->execute(array(':groupid'=>$group->id(),
                            ':name'=>$name,
                            ':year'=>$year,
                            ':month'=>$month,
                            ':day'=>$day,
                            ':hour'=>$hour,
                            ':location'=>$location));

  echo $msg;
                            
}
else { ?>
      <div id="messages">
        <h4>Please correct the following errors:</h4>
        <ul>
          <?php echo $msg; ?>
        </ul>
      </div>
  <?php }?>
