<?php
require_once "db/init.php";
require_once "auth/cas_init.php";
require_once "classes/user.php";

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
?>
<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    if (isset($_POST['t_id'])) {

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
         // echo '<pre>';
         // print_r($row);
         // echo '</pre>';
            ?>
            <div id="post-<?php echo $row->p_id; ?>" class="post">
              <div class="metaPost">
                <p id="postNum">#<?php echo $row->postNumInThread; ?></p>
                <p id="posterName"><?php echo $row->rcsid; ?></p>
                <p id="timeStamp"><?php echo $row->time; ?></p>
              </div>
              <p class="postBody"><?php echo $row->postBody; ?></p>
              <form name="forumPostForm" action="postToThread.php" method="POST">
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
          <input type="hidden" name="threadid" value="<?php echo $_POST['t_id'] ?>">
          <input type="submit" name="isReply" value="Reply to this Thread">
        </form>
        <a  href="createThread.php"><button>Start new Thread</button></a>
      </div>
      <?php
    }else{


      ?>
      <h2>no thread selected</h2>

      <?php 

      try {

        ?>
        <form action="#" method="post">
          <select name="t_id">
            <?php
            $results = $db->query('SELECT * FROM threads');
            foreach ($results as $row) {
             ?>
             <option value="<?php echo $row->t_id; ?>"><?php echo $row->threadName; ?></option>
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
<?php include "resources/footer.php"; ?>
</body>
</html>
