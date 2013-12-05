<?php include "resources/head.php"; ?>

<html>
<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
<script src="js/schedule_meeting.js" />
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">

   <div id="calendar"></div>
   <form method="post" action="">
    <input type="text" name="event_name" />
    <input type="submit" name="submit_meeting" value="Submit Meeting" />
    <div id="timegrid"></div>
   </form>

  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
