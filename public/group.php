<?
require_once "auth/cas_init.php";

require_once "classes/group.php";
$group = new Group($_GET["g"]);

phpCAS::forceAuthentication();
?>
<!DOCTYPE html>
<html>
<head>
  <title>RPI Study Solutions</title>
  <link rel="stylesheet" type="text/css" href="resources/style.css">  
  <link rel="stylesheet" type="text/css" href="resources/calendar.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
<? if ($group->exists()) { ?>
    <h1><?=$group->name()?></h1>
    <section id="calendar">
    <h2><?=$group->name()?> Calendar</h2>
     <script>$('#calendar').datepicker({
    inline: true,
    firstDay: 1,
    showOtherMonths: true,
    dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
    });
    </script>
    <div id="calendar"></div>
    </section>
    <section id="members">
      <h2>Members</h2>
      <ul>
<? foreach ($group->members() as $rcsid => $name) { ?>
        <li><a href="userprofile.php?u=<?=$rcsid?>"><?=$name?></a></li>
<? } ?>
        <!-- TODO: Add a way to add more users to a group if you are in it. -->
      <li><a href="newmembers.php">Invite New Members</a></li>
      </ul>
    </section>

    <section id="threads">
    <h2>Group Thread</h2>
    <?php include "groupThread.php" ?>
    </section>
<? } else { ?>
    This group does not exist.
<? } ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
