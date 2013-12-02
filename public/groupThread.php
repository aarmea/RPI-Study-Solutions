<?php
require_once "db/init.php";
require 'db/config.php';
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
          $conn = new PDO('mysql:host=localhost;dbname=rpi_study_solutions', 'myadmin', 'myadmin');
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $results = $conn->query('SELECT threadName, groupName FROM threads INNER JOIN groups on threads.group_id = groups.groupid WHERE t_id=1');
          foreach ($results as $row) {
            ?>
            <h2><?php echo $row['groupName']; ?> -- <?php echo $row['threadName']; ?></h2>
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
          $conn = new PDO('mysql:host=localhost;dbname=rpi_study_solutions', 'myadmin', 'myadmin');
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $results = $conn->query('SELECT * FROM posts INNER JOIN users on posts.user_id = users.rcsid WHERE t_id=1');
          foreach ($results as $row) {
         // echo '<pre>';
         // print_r($row);
         // echo '</pre>';
            ?>
            <div id="post-<?php echo $row['p_id']; ?>" class="post">
              <div class="metaPost">
                <p id="postNum">#<?php echo $row['postNumInThread']; ?></p>
                <p id="posterName"><?php echo $row['rcsid']; ?></p>
                <p id="timeStamp"><?php echo $row['time']; ?></p>
              </div>
              <p class="postBody"><?php echo $row['postBody']; ?></p>
              <button class="quoteButton">Quote</button>
            </div>
            <?php

          }

        } catch(PDOException $e) {
          echo 'ERROR: ' . $e->getMessage();
        }

        ?>

        <!-- add in posting to thread -->
        <button>Reply to this Thread</button>
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
            $conn = new PDO('mysql:host=localhost;dbname=rpi_study_solutions', 'myadmin', 'myadmin');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $results = $conn->query('SELECT * FROM threads');
            foreach ($results as $row) {
             ?>
             <option value="<?php echo $row['t_id']; ?>"><?php echo $row['threadName']; ?></option>
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
