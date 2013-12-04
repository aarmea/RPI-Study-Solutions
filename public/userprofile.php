<?php
require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
?>
<!doctype html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="resources/calendar.css">
    <link rel="stylesheet" type="text/css" href="resources/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  </head>
  <body>
    <?php include "resources/topbar.php"; ?>
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
      <h3>Next Meeting:</h3>
    </div>
    <h3>Calendar of meetings</h3>
    <div id="hoverDay">Hover over a day to see appointments.</div>
    <div id="calendar"></div>
    <script src="js/calendar.js"></script>
    <div id="notes">
      <h3>Notes to self / Reminders</h3>
      <p>Warning: Saving new notes will replace your old notes.</p>
      <form method="post" class="notes">
      <textarea id="notes" name="notes" rows="10" cols="100" placeholder="My notes..."></textarea>
      <input type="submit" name="save" value="Save" action="userprofile.php"/>
      </form>
      <?php if ($_POST['save'])
      {
        $query=$db->prepare("UPDATE `users` SET `notes`=:text WHERE `rcsid`= :username");
        $query->execute(array(':username'=>$client->username(),
                              ':text'=>$_POST['notes']));
      }?>
      <?php 
      $res = $db->prepare("SELECT `notes` FROM `users` WHERE `rcsid` = :username");
      $res->execute(array(':username'=>$client->username()));
      $results=$res->fetch();
      ?>
      <div id="savedNotes"><p>Saved Notes:<br><?php echo $results->notes; ?></p></div>
    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
