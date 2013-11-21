<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    require 'config.php';
    if (isset($_POST['t_id'])) {

      try {
          $conn = new PDO('mysql:host=' . $config['DB_HOST'] . ';dbname='. $config['DB_DBNAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $results = $conn->query('SELECT threadName, groupName FROM threads INNER JOIN groups on threads.group_id = groups.g_id WHERE t_id=1');
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
        require 'config.php';

        try {
          $conn = new PDO('mysql:host=' . $config['DB_HOST'] . ';dbname='. $config['DB_DBNAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $results = $conn->query('SELECT * FROM posts INNER JOIN user on posts.user_id = user.id WHERE t_id=1');
          foreach ($results as $row) {
         // echo '<pre>';
         // print_r($row);
         // echo '</pre>';
            ?>
            <div id="post-<?php echo $row['p_id']; ?>" class="post">
              <div class="metaPost">
                <p id="postNum">#<?php echo $row['postNumInThread']; ?></p>
                <p id="posterName"><?php echo $row['rcs']; ?></p>
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
        <button>Start new Thread</button>
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
            $conn = new PDO('mysql:host=' . $config['DB_HOST'] . ';dbname='. $config['DB_DBNAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
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
