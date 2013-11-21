<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>Posting to thread <span id="threadName"></span></h2>
    <form name="forumPostForm" action="#" method="POST">
      <h3>Post body:</h3>
      <textarea cols="40" rows="5" name="myname"> Now we are inside the area - which is nice. </textarea>      
      <input type="submit" value="Submit">
    </form>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
