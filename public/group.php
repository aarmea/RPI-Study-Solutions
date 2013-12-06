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
  <?php
  if (isset($_POST['isDelete'])) {
    $res = $db->prepare("DELETE FROM threads WHERE t_id=:t_id;");
    $res->execute(array(':t_id'=>$_POST['t_id']));
  }
  if(isset($_POST['removeMeeting']))
  {
    $id = $_POST['removeMeeting'];

    $query = $db->prepare("DELETE FROM group_meetings WHERE meetingid=:meetingid");

    $query->execute(array(":meetingid"=>$id));
  }
  ?>
<?php include "resources/topbar.php"?>
  <div id="content">
<? if ($group->exists()) { ?>
    <h2>Group: <?=$group->name()?></h2>
    <h3>Meetings</h3>
    <form method="post" action="group.php?g=<?=$group->id()?>" />
      <div id="meetings">
          <?php
        $res = $db->prepare("SELECT DISTINCT * FROM group_meetings
          INNER JOIN groups ON groups.groupid = :groupid
          ORDER BY group_meetings.year,group_meetings.month,group_meetings.day,
                    group_meetings.hour" );
        $res->execute(array(':groupid'=>$group->id()));
        $results=$res->fetchAll();
        $index='0';
        //echo var_dump($results);
        if(sizeof($results)==0) 
          echo "<span>No meetings are scheduled</span>";
        else
        {
          foreach ($results as $row) 
          {
            echo '<p>'.$row->name.':'.$row->month.'/'.$row->day.'/'.$row->year
                .' at '.$row->hour.':00';
            echo '<button type="submit" name="removeMeeting" value = "' . $row->meetingid .'">Remove</button>';
            echo '</p>';
          }
        }
        /*
          $year[$index]=$results->year;
          $month[$index]=$results->month;
          $day[$index]=$results->day;
          $hour[$index]=$results->hour;
          $min[$index]=$results->min;
        }
        if ($hour['0'] < 10) $displayHour='0'.$hour['0'];
        if ($min['0'] < 10) $displayMin='0'.$min['0'];
        echo '<h3>Next Meeting: '.date("F", strtotime($month['0'])).' '.$day['0'].', '.$year['0']
              .' at '.$displayHour.':'.$displayMin.'</h3>';
        */
        ?>
      </div>
    </form>
    <p><a href="scheduleMtg.php?g=<?=$group->id()?>">Schedule a meeting for this group</a></p>
    
    <h3><?=$group->name()?>'s Calendar</h3>

    <div id="calendar"></div>
    <script src="js/calendar.js"></script>
    </section>
    <section id="members">
      <h3>Members</h3>
      <ul>
<? foreach ($group->members() as $rcsid => $name) { ?>
        <li><a href="userprofile.php?u=<?=$rcsid?>"><?=$name?></a></li>
<? } ?> 
      </ul>
      <p><a href="newmembers.php?g=<?=$_GET["g"]?>">Invite New Members</a></p>
    </section>

    <section id="threads">
      <h3>Group Thread</h3>
      <?php
            $results = $db->query('SELECT * FROM threads WHERE group_id=' . $_GET['g']);
            if($results->t_id>0){?>
      <form action="groupThread.php" method="post">
          <select name="t_id">
            <?php foreach ($results as $row) {
             ?>
             <option value="<?php echo $row->t_id; ?>"><?php echo $row->threadName; ?></option>
             <?php

           }
           ?>
         </select>
        <input type="submit" value="Go to thread">
       </form>
      <?php } ?>
       <p><a href="createThread.php">Create New Thread</a></p>
        <?php
        // $results = $db->query('SELECT COUNT(*) FROM `group_members` WHERE groupid=' . $_GET['g'] . ' AND rcsid=' . $client->username() . ' AND is_owner=1');
        $res = $db->prepare('SELECT COUNT(*) FROM `group_members` WHERE groupid=:groupid AND rcsid=:rcsid AND is_owner=1');
        $res->execute(array(':groupid'=>$_POST['g'], ':rcsid'=>$client->username()));
        // todo
        if ($client->isadmin()) {
        ?>
         <form action="#" method="post">
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
          <input type="submit" name="isDelete" value="Delete">
         </form>
        <?php 
        }
        ?>
    </section>
<? } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
