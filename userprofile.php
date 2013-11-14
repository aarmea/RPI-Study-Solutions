<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>User profile of <span id="username"></span></h2>
    <a href="">Settings</a>
    <div id="divOfGroups">
      <h3>list of subscribed groups</h3>
      <ul id="ulOfGroups"></ul>
      <a href="">Create Group</a>
    </div>
    <div id="">
      <h3>Next Meeting:</h3>
      <h4><span id="groupName"></span> on <span id="date"></span> at <span id="time"></span></h4>
    </div>
    <div id="calander">
      <h3>Calander of meetings</h3>
    </div>
    <div id="notes">
      <h3>Notes to self / Reminders</h3>
    </div>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
