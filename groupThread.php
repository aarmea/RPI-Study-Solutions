<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2><span id="groupName"></span> <span id="threadName"></span></h2>
    <div id="posts">
      <div id="examplePost">
        <div class="metaPost">
          <p>#<span id="postNum"></span></p>
          <p><span id="posterName"></span></p>
          <p><span id="timeStamp"></span></p>
        </div>
        <p>This is the main body of the post</p>
        <button>Quote</button>
      </div>
    </div>
    <button>Reply to this Thread</button>
    <button>Start new Thread</button>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
