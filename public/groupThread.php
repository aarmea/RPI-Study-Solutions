<?php
require_once "db/init.php";
require_once "auth/cas_init.php";
require_once "classes/user.php";
require_once "classes/post.php";

require_once "login.php";
phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
?>
  <div id="container">
<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    if (isset($_POST['t_id'])) {
      if (isset($_POST['submit'])) {
        addPost($_POST['t_id'], $client->username(), $_POST['postBody']);
      }

      try {
          $results = $db->query('SELECT threadName, groupName FROM threads INNER JOIN groups on threads.group_id = groups.groupid WHERE t_id=' . $_POST['t_id']);
          foreach ($results as $row) {
            ?>
            <h2><?php echo $row->groupName; ?> -- <?php echo $row->threadName; ?></h2>
            <?php
          }

        } catch(PDOException $e) {
          echo 'ERROR: ' . $e->getMessage();
        }
      ?>
      <div id="posts">
        <?php
        // require 'config.php';

        try {
          $results = $db->query('SELECT * FROM posts INNER JOIN users on posts.user_id = users.rcsid WHERE t_id=' . $_POST['t_id']);
          foreach ($results as $row) {
            ?>
            <div id="post-<?php echo $row->p_id; ?>" class="post">
              <div class="metaPost">
                <p id="postNum">#<?php echo $row->postNumInThread; ?></p>
                <p id="posterName"><?php echo $row->rcsid; ?></p>
                <p id="timeStamp"><?php echo $row->time; ?></p>
              </div>
              <p class="postBody"><?php echo $row->postBody; ?></p>
              <form name="forumPostForm" action="postToThread.php" method="POST">
                <input type="hidden" name="t_id" value="<?php echo $_POST['t_id'] ?>">
                <input type="hidden" name="quote" value="<?php echo '<blockquote>' . $row->postBody . '</blockquote>' ?>">
                <input type="submit" name="isQuote" value="Quote" class="quoteButton">
              </form>
              <!-- <button class="quoteButton">Quote</button> -->
            </div>
            <?php

          }

        } catch(PDOException $e) {
          echo 'ERROR: ' . $e->getMessage();
        }

        ?>

        <!-- add in posting to thread -->
        <form name="forumPostForm" action="postToThread.php" method="POST">
          <input type="hidden" name="t_id" value="<?php echo $_POST['t_id'] ?>">
          <input type="submit" name="isReply" value="Reply to this Thread">
        </form>
        <a  href="createThread.php"><button>Start new Thread</button></a>
      </div>
      <?php
    }else{

      ?>
      <h2>Group select</h2>

      <?php 

      try {

        ?>
        <form action="group.php" method="get">
          <select name="g">
            <?php
            $results = $db->query('SELECT * FROM groups JOIN group_members ON groups.groupid=group_members.groupid WHERE rcsid=\'' . $client->username().'\'');
            print_r($results);
            foreach ($results as $row) {
             ?>
             <option value="<?php echo $row->groupid; ?>"><?php echo $row->groupname; ?></option>
             <?php

           }
           ?>
         </select>
        <input type="submit" value="Submit">
       </form>
       <?php

     } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }
  } 
  ?>

</div>
</div>
<?php include "resources/footer.php"; ?>
</body>
</html>
