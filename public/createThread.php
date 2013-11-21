<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <?php
    if (isset($_POST['group_id'])) {
      require 'config.php';
      try {
        $conn = new PDO('mysql:host=' . $config['DB_HOST'] . ';dbname='. $config['DB_DBNAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO threads (group_id, threadName) VALUES (:group_id, :threadName)");
        $success = $stmt->execute(array(':group_id' => $_POST['group_id'], ':threadName' => $_POST['threadName']));
        if ($success) {
          $stmt = $conn->prepare("SELECT `t_id` FROM `threads` WHERE group_id = :group_id AND threadName = :threadName");
          $stmt->execute(array(':group_id' => $_POST['group_id'], ':threadName' => $_POST['threadName']));
          $res = $stmt->fetch();
          // $res['t_id']

          $stmt = $conn->prepare("INSERT INTO posts (t_id, user_id, postBody, postNumInThread) VALUES (:t_id, :u_id, :postBody, :postNumInThread)");
          $success = $stmt->execute(array(':t_id' => $res['t_id'], ':u_id' => 1, ':postBody' => $_POST['postBody'], ':postNumInThread' => 1));
          if ($success) {
            echo '<p id="message">The thread has been created!</p>';
          }
        }        

      } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
      }
    }
    ?>
    <h2>Create Thread</h2>
    <form action="#" method="post">
      <label>Group_id:</label>
      <select name="group_id">
        <option value="1">Volvo</option>
        <option value="1">Saab</option>
        <option value="1">Opel</option>
        <option value="1">Audi</option>
      </select>
      <label>Thread Name:</label>
      <input type="text" name="threadName">
      <label>Post Body:</label>
      <textarea cols="40" rows="5" name="postBody"> Now we are inside the area - which is nice. </textarea>
      <input type="submit" value="Submit">
    </form>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
