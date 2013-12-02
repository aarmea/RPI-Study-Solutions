<?
require_once "auth/cas_init.php";

require_once "classes/group.php";
$group = new Group($_GET["g"]);

phpCAS::forceAuthentication();

include "resources/head.php";
?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
<? if ($group->exists()) { ?>
    <h1><?=$group->name()?></h1>
    <section id="calendar">
      <!-- TODO: Group calendar -->
    </section>

    <section id="members">
      <h2>Members</h2>
      <ul>
<? foreach ($group->members() as $rcsid => $name) { ?>
        <li><a href="userprofile.php?u=<?=$rcsid?>"><?=$name?></a></li>
<? } ?>
        <!-- TODO: Add a way to add more users to a group if you are in it. -->
      </ul>
    </section>

    <section id="threads">
      <!-- TODO: Group forum threads -->
    </section>
<? } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
