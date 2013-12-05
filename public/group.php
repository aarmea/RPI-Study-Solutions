<?
require_once "auth/cas_init.php";
require_once "classes/group.php";
$group = new Group($_GET["g"]);
phpCAS::forceAuthentication();
?>
<!DOCTYPE html>
<html>
<head>
<link href="resources/style.css" rel="stylesheet" type="text/css" />
<link href="resources/calendar.css" rel="stylesheet" type="text/css" />
<link href="donottouch.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.kwicks-1.5.1.pack.js"></script>
<script src="js/profile.js"></script>
<script type="text/javascript">
$().ready(function() {
$('.jimgMenu ul').kwicks({max: 310, duration: 300, easing: 'easeOutQuad'});
});
</script>
</head>
<body>
    <div class="jimgMenu">
      <ul>
        <li id="logo"><a href="index.php">Home Page</a></li>
        <li id="people"><a href="createThread.php">Create Group</a></li>
        <li id="post"><a href="postToThread.php">Post to thread</a></li>
        <li id="explore"><a href="groupThread.php">View groups</a></li>
        <li id="profile"><a href="userprofile.php">stuffs</a></li>
        <li id="setting"><a href="settings.php">stuffs</a></li>
        <li id="login"><a href="login.php">stuffs</a></li>
      </ul>
    </div>
    <br  style="clear:both"/><br />
  <div id="content">
<? if ($group->exists()) { ?>
    <h1><?=$group->name()?></h1>
    <div id="meetings">
        <?php
      $res = $db->prepare("SELECT * FROM group_meetings
        INNER JOIN groups ON groups.groupid = :groupid
        ORDER BY group_meetings.year,group_meetings.month,group_meetings.day,
                  group_meetings.hour,group_meetings.min " );
      $res->execute(array(':groupid'=>$group->id()));
      $results=$res->fetch();
      $index='0';
      if(sizeof($results->day)==0) echo "<h3>No meetings are scheduled</h3>";
      else
      {
        foreach ($results as $row) 
        {
          $year[$index]=$results->year;
          $month[$index]=$results->month;
          $day[$index]=$results->day;
          $hour[$index]=$results->hour;
          $min[$index]=$results->minute;
        }
        echo '<h3>Next Meeting: '.$month['0'].' '.$day['0'].' '.$year['0']
              .' at '.$hour['0'].':'.$min['0'].'</h3>';
      }
      ?>
    </div>
    <section id="calendar">
    <h2><?=$group->name()?> Calendar</h2>
     <script>
     $('#calendar').datepicker({
    inline: true,
    firstDay: 1,
    showOtherMonths: true,
    dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
    });
    </script>
    <div id="calendar"></div>
    </section>
    <section id="members">
      <h2>Members</h2>
      <ul>
<? foreach ($group->members() as $rcsid => $name) { ?>
        <li><a href="userprofile.php?u=<?=$rcsid?>"><?=$name?></a></li>
<? } ?>
        <!-- TODO: Add a way to add more users to a group if you are in it. -->
      <li><a href="newmembers.php">Invite New Members</a></li>
      </ul>
    </section>

    <section id="threads">
    <h2>Group Thread</h2>
    </section>
<? } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
