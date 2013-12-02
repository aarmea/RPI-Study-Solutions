<?php

  require_once "db/init.php";
  require 'db/config.php';
  require_once "auth/cas_init.php";
  require_once "classes/user.php";

  phpCAS::forceAuthentication();
  $client = new User(phpCAS::getUser());
  $rcsid = $client->username();

  //Get email from database here
  function getEmail() {
    
    global $client;
    return $client->altEmail();

  }

  //Get the available times from database here
  function getAvailableTimes() {

    global $db;
    global $rcsid;

    $dbh = $db->prepare("SELECT year,month,hour,day FROM available_times WHERE rcsid=:rcsid");
    $dbh->execute(array(":rcsid" => $rcsid));
    $result = $dbh->fetchAll();

    return $result;

    //Return an array of arrays of [year month day hour]
    //return array( array(2013,11,28,8), array(2013,11,28,9) );
  }

  //Get notifications from database here
  function getNotifications() {
    //0 means not checked. 1 means checked
    return array(0,0,0);
  }

  $date = getdate();

  $year = $date['year'];
  $mon = $date['mon'];
  $day = $date['mday'];
  $time_arr = getAvailableTimes();

?>

<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php";?>

  <script type='text/javascript'>
    var year = <?php echo $year ?>;
    var month = <?php echo $mon ?>;
    var day = <?php echo $day ?>;
    var available_times = 
      <?php

        $js_ret_arr = '[';
        for($i=0;$i<count($time_arr);$i++) {
          
          $js_ret_arr = $js_ret_arr . '[';
          $js_ret_arr = $js_ret_arr . $time_arr[$i]->year . ",";
          $js_ret_arr = $js_ret_arr . $time_arr[$i]->month . ",";
          $js_ret_arr = $js_ret_arr . $time_arr[$i]->day . ",";
          $js_ret_arr = $js_ret_arr . $time_arr[$i]->hour;
          $js_ret_arr = $js_ret_arr . ']';
          
          if($i != count($time_arr)-1)
            $js_ret_arr = $js_ret_arr . ',';
        }
        $js_ret_arr = $js_ret_arr . ']';

        echo $js_ret_arr;

      ?>;

    for(var i=0;i<available_times.length;i++) {
      for(var j=0;j<4;j++){
        console.log(available_times[i][j]);
      }
    }

  </script>
  <script src="whenisgood/whenisgood.js"></script>
  <link type='text/css' rel="stylesheet" href="whenisgood/whenisgood.css"></link>
  <div id="content">
    <form id="post_settings" action="post_settings.php" method="post">
      <h2>Settings</h2>
      <div id="calendarSettings">
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
        <h3>Change alt email for reminders</h3>
          <input type="input" name="email" value= <?php echo '"' . getEmail() . '"'; ?> />
        <input id="posthidden" type="hidden" name="dates" />
        <br/><br/><br/>
          <input id="submit" type="submit" name="SubmitChanges" value="Submit Changes" />
      </form>

      <div id="refreshed">
      </div>

    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
