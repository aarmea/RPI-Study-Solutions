<?php
require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";
$group = new Group($_GET["g"]);
require_once "login.php"
?>
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
<?php include "resources/topbar.php" ?>
  <div id="content">
<? if ($group->exists()) { ?>
    <h2><?=$group->name()?></h2>
    <h3>Meetings</h3>
    <form method="post" action="group.php?g=<?=$group->id()?>" />
      <div id="meetings">
          <?php
        $res = $db->prepare("SELECT DISTINCT * FROM group_meetings
          WHERE group_meetings.groupid = :groupid
          ORDER BY group_meetings.year,group_meetings.month,group_meetings.day,
                    group_meetings.hour" );
        $res->execute(array(':groupid'=>$group->id()));
        $results=$res->fetchAll();
        //echo var_dump($results);
        if(sizeof($results)==0) 
          echo "<span>No meetings are scheduled</span>";
        else
        {
          foreach ($results as $row) 
          {
            $name=$row->name;
            $year=$row->year;
            $month=$row->month;
            $day=$row->day;
            $hour=$row->hour;
            $min=$row->min;
            $location=$row->location;
            if ($hour < 10) $displayHour='0'.$hour; else $displayHour=$hour;
            if ($min < 10) $displayMin='0'.$min; else $displayMin=$min;
            echo '<p>'.$name.'<br>'.date("F", strtotime($month)).' '.$day.', '.$year
                  .' at '.$displayHour.':'.$displayMin.' '.$location.
            '<button type="submit" name="removeMeeting" value = "' . $row->meetingid .'">Remove</button></p>';
          }
        }
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
        $res = $db->prepare('SELECT COUNT(*) FROM `threads` WHERE group_id=:groupid');
        $res->execute(array(':groupid'=>$_GET['g']));
        $isEmpty = $res->fetch();
        $isEmpty = get_object_vars($isEmpty);
        if ($isEmpty['COUNT(*)'] >= 1) {          
            $results = $db->query('SELECT * FROM threads WHERE group_id=' . $_GET['g']);
            ?>
      <form action="groupThread.php" method="post">
          <input type="hidden" name="groupid" value="<?php echo $_GET['g'] ?>">
          <select name="t_id">
            <?php foreach ($results as $row) { ?>
             <option value="<?php echo $row->t_id; ?>"><?php echo $row->threadName; ?></option>
             <?php } ?>
         </select>
        <input type="submit" value="Go to thread">
       </form>
       <?php } ?>
      <form action="createThread.php" method="post">
         <input type="hidden" name="group_id" value="<?php echo $_GET['g']; ?>">
         <input type="submit" value="Create new thread">
        </form>
        <?php
        $res = $db->prepare('SELECT COUNT(*) FROM `group_members` WHERE groupid=:groupid AND rcsid=:rcsid AND is_owner=1');
        $res->execute(array(':groupid'=>$_GET['g'], ':rcsid'=>$client->username()));
        $isOwner = $res->fetch();
        $isOwner = get_object_vars($isOwner);
        if ($isOwner['COUNT(*)'] >= 1) {
          $res = $db->prepare('SELECT COUNT(*) FROM `threads` WHERE group_id=:groupid');
          $res->execute(array(':groupid'=>$_GET['g']));
          $isEmpty = $res->fetch();
          $isEmpty = get_object_vars($isEmpty);
          if ($isEmpty['COUNT(*)'] >= 1) {
            $results = $db->query('SELECT * FROM threads WHERE group_id=' . $_GET['g']);
          ?>
           <form action="#" method="post">
              <select name="t_id">
                <?php foreach ($results as $row) {?>
                 <option value="<?php echo $row->t_id; ?>"><?php echo $row->threadName; ?></option>
                 <?php }?>
             </select>
            <input type="submit" name="isDelete" value="Delete">
            </form>
          <?php } } ?>
    </section>
<?  } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
