<?
require_once "classes/group.php";
$group = new Group($_GET["g"]);

include "resources/head.php";
?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
<? if ($group->exists()) { ?>
    <h1><?=$group->name()?></h1>
    <section id="calendar">
      <!-- TODO -->
    </section>

    <section id="members">
      <h2>Members</h2>
      <ul>
<? foreach ($group->members() as $rcsid => $name) { ?>
        <li><a href="userprofile.php?u=<?=$rcsid?>"><?=$name?></a></li>
<? } ?>
      </ul>
    </section>

    <section id="threads">
      <!-- TODO -->
    </section>
<? } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
