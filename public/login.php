<?
require_once "auth/cas_init.php";
phpCAS::forceAuthentication();
?>
<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>Welcome, <?=phpCAS::getUser()?></h2>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
