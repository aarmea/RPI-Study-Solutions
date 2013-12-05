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

        <div style="width:80%">
        <div id = "cur_week"></div>
      </div>
        <button id="prevweek">Previous Week</button>
        <button id="nextweek">Next Week</button>

        <div id="timegrid"></div>
        <div id="timegrid2"></div>
        <div id="timegrid3"></div>
        <div id="timegrid4"></div>
        <div id="timegrid5"></div>
        <div id="timegrid6"></div>
        <div id="timegrid7"></div>
        <div id="timegrid8"></div>
        <div id="timegrid9"></div>
        <div id="timegrid10"></div>
      </div>
      
        <button id="selectall">Select All</button>
        <button id="unselectall">Unselect All</button>
      
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

