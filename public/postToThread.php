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
    if (isset($_POST['submit'])) {
      addPost($_POST['thread_id'], $client->username(), $_POST['postBody']);
    }
    ?>
    <h2>Posting to thread <?php echo "that one thread"; ?></h2>
    <form name="forumPostForm" action="#" method="POST">
      <!-- <label>Thread Name:</label> -->
      <input type="hidden" name="thread_id" value="<?php echo $_POST['thread_id']; ?>">
      <!-- <select name="thread_id">
        <?php
          $threads = listThreads();
          foreach ($threads as $key => $value) {
            ?>
            <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
            <?php
          }
        ?>
      </select> -->
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
