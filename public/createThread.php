<?php
require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
require_once "classes/group.php";

require_once "login.php"
?>
<div id="container">
<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    if (isset($_POST['group_id'])) {
      $group = new Group($_POST['group_id']);
    }
    if (isset($_POST['submit'])) {
      try {

        $stmt = $db->prepare("INSERT INTO threads (group_id, threadName) VALUES (:group_id, :threadName)");
        $success = $stmt->execute(array(':group_id' => $_POST['group_id'], ':threadName' => $_POST['threadName']));
        if ($success) {
          $stmt = $db->prepare("SELECT `t_id` FROM `threads` WHERE group_id = :group_id AND threadName = :threadName");
          $stmt->execute(array(':group_id' => $_POST['group_id'], ':threadName' => $_POST['threadName']));
          $res = $stmt->fetch();

          $stmt = $db->prepare("INSERT INTO posts (t_id, user_id, postBody, postNumInThread) VALUES (:t_id, :u_id, :postBody, :postNumInThread)");
          $stmt->execute(array(':t_id' => $res->t_id, ':u_id' => $client->username(), ':postBody' => $_POST['postBody'], ':postNumInThread' => 1));
          echo '<p id="message">The thread has been created!</p>';
        }        

      } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
      }
    }
    ?>
    <h2>Create Thread for <?php echo $group->name(); ?></h2>
    <form action="#" method="post">

      <label>Group_id:</label>
      <select name="group_id">

      <input type="hidden" name="group_id" value="<?php echo $group->id(); ?>">

        <?php
          $groups = listGroups();
          foreach ($groups as $key => $value) {
            ?>
            <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
            <?php
          }
        ?>
      </select> -->
      <label>Thread Name:</label>
      <input type="text" name="threadName">
      <label>Post Body:</label>
      <textarea cols="40" rows="5" name="postBody"> Now we are inside the area - which is nice. </textarea>
      <input type="submit" name="submit" value="Submit">
    </form>
  </div>
</div>
    <?php include "resources/footer.php"; ?>
</body>
</html>
