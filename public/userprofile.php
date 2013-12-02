<?php
require_once "auth/cas_init.php";
require_once "classes/user.php";

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());

// TODO: A way to show profiles specified with $_GET["u"]

include "resources/head.php";
?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>Welcome, <?=$client->shortname()?></h2>
    <img src="<?=$client->imageURL()?>">
    <p><?=$client->fullname()?>
      <span id="username"><?=$client->username()?></span></p>
    <p><?=$client->major()?>, Class of <?=$client->yog()?></p>
    <a href="">Settings</a>
    <div id="divOfGroups">
      <h3>list of subscribed groups</h3>
      <!-- TODO: Populate this list -->
      <ul id="ulOfGroups"></ul>
      <!-- TODO: List of groups you administrate/own -->
    </div>
    <div id="">
      <h3>Next Meeting:</h3>
      <h4><span id="groupName"></span> on <span id="date"></span> at <span id="time"></span></h4>
    </div>
    <div id="calendar">
      <h3>Calendar of meetings</h3>
    </div>
    <div id="notes">
      <h3>Notes to self / Reminders</h3>
    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
