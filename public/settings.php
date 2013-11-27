<?php

  $year = getdate()['year'];
  $mon = getdate()['mon'];
  $day = getdate()['mday'];

  if(isset($_POST['SubmitChanges'])) {

    /*
    if(isset($_POST['rem_set_1']))
      echo $_POST['rem_set_1'] . "<br>";
    if(isset($_POST['rem_set_2']))
      echo $_POST['rem_set_2'] . "<br>";
    if(isset($_POST['rem_set_3']))
      echo $_POST['rem_set_3'] . "<br>";
    if(isset($_POST['rem_set_3']))
      echo $_POST['rem_set_3'] . "<br>";
    if(isset($_POST['email']))
      echo $_POST['email'] . "<br>";
    if(isset($_POST['alt_email']))
      echo $_POST['alt_email'] . "<br>";
    */
      
  }
  else
  {
    //Load stuff from database into DOM here...
  }
?>

<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <script type='text/javascript'>
    var year = <?php echo $year ?>;
    var month = <?php echo $mon ?>;
    var day = <?php echo $day ?>;
  </script>
  <script src="whenisgood/whenisgood.js"></script>
  <link type='text/css' rel="stylesheet" href="whenisgood/whenisgood.css"></link>
  <div id="content">
    <form method="post" action="settings.php">
      <h2>Settings</h2>
      <div id="calanderSettings">
        <h3>Link google calander</h3>
        <h3>- or -</h3>
        <h3>Set availibility</h3>
        <div id="timegrid"></div>
      </div>
      <div id="reminderSettings">
        <h3>Reminder setting</h3>
          <input type="checkbox" name="rem_set_1" value="op1">op1<br>
          <input type="checkbox" name="rem_set_2" value="op2">op2<br>
          <input type="checkbox" name="rem_set_3" value="op3">op3<br>
        <h3>Change primary email for reminders</h3>
          <input type="input" name="email" value="(email goes here)" />
        <h3>add alternative email</h3>
          <input type="input" name="alt_email" value="(alt email goes here)" />
        <br/><br/><br/>
          <input type="submit" name="SubmitChanges" value="Submit Changes" />
      </form>
    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
