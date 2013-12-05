<?php
require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
require_once "classes/group.php";
require_once "classes/thread.php";
require_once "classes/post.php";

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
?>
<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    print_r($_POST);
    if (isset($_POST['submit'])) {
      addPost($_POST['thread_id'], $client->username(), $_POST['postBody']);
    }
    ?>
    <?php $the_thread = new Thread($_POST['thread_id']) ?>
    <h2>Posting to <?php echo $the_thread->name(); ?></h2>
    <form name="forumPostForm" action="#" method="POST">
      <input type="hidden" name="thread_id" value="<?php echo $_POST['thread_id']; ?>">
      <h3>Post body:</h3>
      <textarea cols="40" rows="5" name="postBody"><?php
        if (isset($_POST['isQuote'])) {
          echo $_POST['quote'];
        }
       ?></textarea>      
      <input type="submit" name="submit" value="Submit">
    </form>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
