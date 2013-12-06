<?php
require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());

if (isset($_POST["create_group"]) && isset($_POST["name"])) {
  $members = array(phpCAS::getUser());
  if (isset($_POST["members"])) {
    $members = array_merge(
      $members, array_map("trim", array_filter(explode(",", $_POST["members"]))));
  }
  $newGroup = addGroup($_POST["name"], $members);

  // Successfully added group, redirect to it
  header("Location: group.php?g=" . $newGroup->id());
}

include "resources/head.php";
?>
<div id="container">
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>Create Group</h2>
    <form method=post action="newgroup.php">
      <label for="groupname_input">Group name:</label>
      <input id="groupname_input" type="text" name="name" required>
      <label for="members_input">Additional group members (by RCS ID):</label>
      <input id="members_input" type="text" name="members" value="">
      <input type="submit" name="create_group" value="Create">
    </form>
  </div>
</div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
