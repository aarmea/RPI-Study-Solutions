<?php
require_once "classes/group.php";

include "resources/head.php";
?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
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
