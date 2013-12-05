<?php
require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";
$group = new Group($_GET["g"]);
require_once "login.php"
?>
<!DOCTYPE html>
<html>
<head>
  <title>RPI Study Solutions</title>
  <link rel="stylesheet" type="text/css" href="resources/style.css">  
  <link rel="stylesheet" type="text/css" href="resources/calendar.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
<?php include "resources/topbar.php"?>
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
    <p><a href="scheduleMtg.php">Schedule a meeting for this group</p>
    <h2><?=$group->name()?> Calendar</h2>
    <div id="calendar"></div>
     <script>
     $('#calendar').datepicker({
    inline: true,
    firstDay: 1,
    showOtherMonths: true,
    dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
    });
    </script>
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
      <form action="groupThread.php" method="post">
          <select name="t_id">
            <?php
            $results = $db->query('SELECT * FROM threads WHERE group_id=' . $_GET['g']);
            foreach ($results as $row) {
             ?>
             <option value="<?php echo $row->t_id; ?>"><?php echo $row->threadName; ?></option>
             <?php

           }
           ?>
         </select>
        <input type="submit" value="Go to thread">
       </form>
       <form action="createThread.php" method="post">
        <input type="hidden" name="group_id" value="<?php echo $_GET['g']; ?>">
        <input type="submit" value="Create new thread">
       </form>
    </section>
<? } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
