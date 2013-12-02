<?php
require_once "auth/cas_init.php";
require_once "classes/user.php";

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());

// TODO: A way to show profiles specified with $_GET["u"]

include "resources/head.php";
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
      <h3>list of subscribed groups</h3>
      <!-- TODO: Populate this list -->
      <ul id="ulOfGroups"></ul>
      <!-- TODO: List of groups you administrate/own -->
    </div>
    <div id="">
      <h3>Next Meeting:</h3>
      <h4><span id="groupName"></span> on <span id="date"></span> at <span id="time"></span></h4>
    </div>
    <h3>Calendar of meetings</h3>
    <div id="hoverDay">Hover over a day to see appointments.</div>
    <div id="calendar"></div>
    <script>
    $('#calendar').datepicker({
        inline: true,
        firstDay: 1,
        showOtherMonths: true,
        dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
    });
    $(function() {
      $("#datepicker").datepicker();
      $(".ui-state-default").live("mouseover", function() {
        $("#hoverDay").text($(this).text());
       });
      $(".ui-state-default").live("mouseout", function() {
        $("#hoverDay").text('Hover over a day to see appointments.');
       });
    });
    </script>
    <div id="notes">
      <h3>Notes to self / Reminders</h3>
      <!-- post old content if it exists -->
      <?php echo $var = isset($_POST['notesContent']) ? $_POST['notesContent'] : ''; ?>
      <!-- create new content -->
      <textarea id="notes" rows="10" cols="100" placeholder="My notes..."><textarea>
      <input type="submit" name="save" value="Save" action="userprofile.php"/>
      <!--save content -->
      <?php if ($_POST['submit'])
      {
        $text = mysql_real_escape_string($_POST['notes']); 
        $query="INSERT INTO users (notes) VALUES ('$text')";
        mysql_query($query) or die ('Error updating database' . mysql_error());
      }?>
    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
