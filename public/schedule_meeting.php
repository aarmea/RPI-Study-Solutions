<?php include "resources/head.php"; ?>

<style>
  .ui-state-selected
  {
    background:green;
  }
</style>

<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">

   <div id="calendar"></div>
   <script src="js/schedule_meeting.js"></script>
   <form method="post" action="">
    <label>Event Name</label><input type="text" name="event_name" />
    <input type="submit" name="submit_meeting" value="Submit Meeting" />
    <div id="timegrid"></div>
   </form>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
