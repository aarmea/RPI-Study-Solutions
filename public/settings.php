<?php

  //Get email from database here
  function getEmail() {
    return "Placeholder Email";
  }

  //Get alt email from database here
  function getAltEmail() {
    return "Placeholder alt email";
  }

  //Get the available times from database here
  function getAvailableTimes() {
    //Return an array of arrays of [year month day hour]
    return array( array(2013,10,28,8), array(2013,10,28,9) );
  }

  //Get notifications from database here
  function getNotifications() {
    //0 means not checked. 1 means checked
    return [0,0,0];
  }

  $year = getdate()['year'];
  $mon = getdate()['mon'];
  $day = getdate()['mday'];
  $time_arr = getAvailableTimes();

  //Update the database here with new values
  if(isset($_POST['SubmitChanges'])) {

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
    var available_times = 
      <?php

        $js_ret_arr = '[';
        for($i=0;$i<count($time_arr);$i++) {
          
          $js_ret_arr = $js_ret_arr . '[';
          for($j=0;$j<4;$j++) {
            $js_ret_arr = $js_ret_arr . $time_arr[$i][$j];
            if($j != 3)
              $js_ret_arr = $js_ret_arr . ',';
          }
          $js_ret_arr = $js_ret_arr . ']';
          if($i != count($time_arr)-1)
            $js_ret_arr = $js_ret_arr . ',';
        }
        $js_ret_arr = $js_ret_arr . ']';

        echo $js_ret_arr;

      ?>;

    /*
    for(var i=0;i<available_times.length;i++) {
      for(var j=0;j<4;j++){
        console.log(available_times[i][j]);
      }
    }
    */

  </script>
  <script src="whenisgood/whenisgood.js"></script>
  <link type='text/css' rel="stylesheet" href="whenisgood/whenisgood.css"></link>
  <div id="content">
    <form method="post" action="settings.php">
      <h2>Settings</h2>
      <div id="calendarSettings">
        <h3>Link google calendar</h3>
        <h3>- or -</h3>
        <h3>Set availability</h3>
        <div id="timegrid"></div>
      </div>
      <div id="reminderSettings">
        <h3>Reminder setting</h3>
          <?php

            $arr = getNotifications();
          
            if($arr[0] == 0)
              echo '<input type="checkbox" name="rem_set_1" value="op1">op1<br>';
            else
              echo '<input type="checkbox" name="rem_set_1" value="op1" checked>op1<br>';

            if($arr[1] == 0)
              echo '<input type="checkbox" name="rem_set_2" value="op2">op2<br>';
            else
              echo '<input type="checkbox" name="rem_set_2" value="op2" checked>op2<br>';

            if($arr[2] == 0)
              echo '<input type="checkbox" name="rem_set_3" value="op3">op3<br>';
            else
              echo '<input type="checkbox" name="rem_set_3" value="op3" checked>op3<br>';

          ?>
        <h3>Change primary email for reminders</h3>
          <input type="input" name="email" value= <?php echo '"' . getEmail() . '"'; ?> />
        <h3>add alternative email</h3>
          <input type="input" name="alt_email" value= <?php echo '"' . getAltEmail() . '"'; ?> />
        <br/><br/><br/>
          <input type="submit" name="SubmitChanges" value="Submit Changes" />
      </form>

      <button id="submit">JS_SUBMIT</button>

      <div id="refreshed">
        <?php
        if(isset($_POST['SubmitChanges'])) {
          echo "Settings saved";
        }
        ?>
      </div>

    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
