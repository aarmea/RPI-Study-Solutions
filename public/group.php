<?php
require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";
$group = new Group($_GET["g"]);
require_once "login.php"
?>

<style>
p, a
{
  font-size:15px;
}
a
{
  font-weight:bold;
}
</style>
<?php include "resources/head.php"; ?>
<body>
<?php include "resources/topbar.php"?>
  <div id="content">
<? if ($group->exists()) { ?>
    <h2>Group: <?=$group->name()?></h2>
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
    <a href="scheduleMtg.php?g=<?=$group->id()?>"><button>Schedule a meeting for this group</button></a>
    <h3><?=$group->name()?>'s Calendar</h3>
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
      <h3>Members</h3>
      <ul>
<? foreach ($group->members() as $rcsid => $name) { ?>
        <li><a href="userprofile.php?u=<?=$rcsid?>"><?=$name?></a></li>
<? } ?>
        <!-- TODO: Add a way to add more users to a group if you are in it. -->
        
      </ul>
      <a href="newmembers.php"><button>Invite New Members</button></a>
    </section>

    <section id="threads">
      <h3>Group Thread</h3>
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
