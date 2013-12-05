<?php
require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
?>
<?php include "resources/head.php";?>
  </head>
  <body>
    <?php include "resources/topbar.php";?>
    <div id="content">
    <h2>Welcome, <?=$client->shortname()?></h2>
     <img src="<?=$client->imageURL()?>">
    <p><?=$client->fullname()?>
      <span id="username"><?=$client->username()?></span></p>
    <p><?=$client->major()?>, Class of <?=$client->yog()?></p>
    <a href="settings.php">Settings</a>
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
    <div id="meetings">
        <?php
      $res = $db->prepare("SELECT * FROM group_meetings
        INNER JOIN group_members ON group_members.rcsid = :username
        ORDER BY group_meetings.year,group_meetings.month,group_meetings.day,
                  group_meetings.hour,group_meetings.min " );
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
          $min[$index]=$results->minute;
        }
        echo '<h3>Next Meeting: '.$month['0'].' '.$day['0'].' '.$year['0']
              .' at '.$hour['0'].':'.$min['0'].'</h3>';
      }
      ?>
    </div>
    <h3>Calendar</h3>
    <div id="hoverDay">Hover over a day to see appointments.</div>
    <div id="calendar"></div>
    <script src="js/calendar.js"></script>
    <div id="notes">
      <h3>Notes to self / Reminders</h3>
      <p>Warning: Saving new notes will replace your old notes.</p>
      <form method="post" class="notes">
        <textarea id="notes" name="notes" rows="10" cols="100" placeholder="My notes..."></textarea>
        <input id="submitNotes" type="submit" name="save" value="Save"/>
      </form>
      <?php
        $res = $db->prepare("SELECT `notes` FROM `users` WHERE `rcsid` = :username");
        $res->execute(array(':username'=>$client->username()));
        $results=$res->fetch();
      ?>
      <div id="savedNotes"><p>Saved Notes:<br><span id="theNotes"><?php echo $results->notes ?></span></p></div>
    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
