<?php
require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
require_once "classes/group.php";
require_once "classes/thread.php";
require_once "classes/post.php";
require_once "login.php"
?>
<?php 
if (!isset($_POST['t_id'])) {
  header( 'Location: ./groupThread.php' ) ;
}
include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    if (isset($_POST['t_id'])) {
      $the_thread = new Thread($_POST['t_id']) 
    ?>
    <h2>Posting to <?php echo $the_thread->name(); ?></h2>
    <form name="forumPostForm" action="groupThread.php" method="POST">
      <input type="hidden" name="t_id" value="<?php echo $_POST['t_id']; ?>">
      <h3>Post body:</h3>
      <textarea cols="40" rows="5" name="postBody"><?php
        if (isset($_POST['isQuote'])) {
          echo $_POST['quote'];
        }
       ?></textarea>      
      <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    }
    ?>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
