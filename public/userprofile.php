<?php
require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
require_once "login.php"
?>

<?php include "resources/head.php";?>
  <body>
    <?php
    if (isset($_POST['isDelete'])) {
      $res = $db->prepare("DELETE FROM groups WHERE groupid=:groupid;" );
      $res->execute(array(':groupid'=>$_POST['g_id']));
    }
    ?>
    <script src="js/profile.js"></script>
    <?php include "resources/topbar.php";?>
    <div id="container">
    <div id="content2">
    <h2 id="welcome">Welcome, 
      <?php 
        echo $client->shortname();
        if($client->isadmin() == true)
          echo "<br>You are logged in as admin";
      ?>
    </h2>
     <img class="profile" src="<?=$client->imageURL()?>">
    <div id="userInfo">
    <p><?=$client->fullname()?>
      <span id="username"><?=$client->username()?></span></p>
    <p><?=$client->major()?>, Class of <?=$client->yog()?></p>
  </div>
    <p><a href="settings.php">Settings</a></p>
    <div id="divOfGroups">
      <h3>Subscribed Groups:</h3>
      <ul id="ulOfGroups">
      <?
      $groups = $client->groups();
      foreach ($groups as $name => $id) {
      ?>
      <li><a href="group.php?g=<?=$id?>"><?=$name?></a></li>
      <? } ?>
      </ul>
      <a href="newgroup.php">Create a group</a>
    </div>
    <?php 
    if ($client->isadmin()) {
    ?>
     <form action="#" method="post">
      <h2>Admin Delete a group</h2>
        <select name="g_id">
          <?php
          $results = $db->query('SELECT * FROM groups');
          foreach ($results as $row) {
           ?>
           <option value="<?php echo $row->groupid; ?>"><?php echo $row->groupname; ?></option>
           <?php
         }
         ?>
       </select>
      <input type="submit" name="isDelete" value="Delete">
     </form>
    <?php 
    }
    ?>
    <div id="meetings">
        <?php
      $res = $db->prepare("SELECT * FROM group_meetings
        INNER JOIN group_members ON group_members.rcsid = :username
        ORDER BY group_meetings.year,group_meetings.month,group_meetings.day,
                  group_meetings.hour" );
      $res->execute(array(':username'=>$client->username()));
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
          $min[$index]=$results->min;
          $location[$index]=$results->location;
        }
        if ($hour['0'] < 10) $displayHour='0'.$hour['0']; else $displayHour=$hour['0'];
        if ($min['0'] < 10) $displayMin='0'.$min['0']; else $displayMin=$min['0'];
        echo '<h3>Next Meeting: '.date("F", strtotime($month['0'])).' '.$day['0'].', '.$year['0']
              .' at '.$displayHour.':'.$displayMin.' '.$location['0'].'</h3>';
      }
      ?>
    </div>
    <h3>Calendar</h3>
    <div id="calendar"></div>
    <div id="hoverDay" style="font-size:15px">Hover over a day to see appointments.</div>
    <script src="js/calendar.js"></script>
     <div id="notes">
      <h3>Notes to self / Reminders</h3>
      <p>Warning: Saving new notes will replace your old notes.</p>
      
      <form id="mainForm" method="post" class="notes">
        <textarea id="notes" name="notes" rows="10" cols="100" placeholder="My notes..."></textarea>
        <input id="submitNotes" type="submit" name="save" value="Save"/>
        <input id="hyear" type="hidden" name="hyear" />
        <input id="hmonth" type="hidden" name="hmonth" />
        <input id="hday" type="hidden" name="hday" />
      </form>
      
      <?php
              $res = $db->prepare("SELECT `notes` FROM `users` WHERE `rcsid` = :username");
              $res->execute(array(':username'=>$client->username()));
              $results=$res->fetch();
            ?>
      <div id="savedNotes"><p style="font-weight:bold">Saved Notes:<br><pre id="theNotes" style="font-size:15px"><?php echo $results->notes ?></pre></p></div>
    </div>
  </div>
</div>
 <?php include "resources/footer2.php"; ?>
</body>
</html>
