<?php
require_once "auth/cas_init.php";

require_once "classes/group.php";

phpCAS::forceAuthentication();

include "resources/head.php";
?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <a href="newgroup.php">Create a new group</a>
    <h2>Available Groups:</h2>
    <ul>
<?
$groups = listGroups();
foreach ($groups as $name => $id) {
?>
      <li><a href="group.php?g=<?=$id?>"><?=$name?></a></li>
<? } ?>
    </ul>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
