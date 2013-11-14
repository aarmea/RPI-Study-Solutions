<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2><span id="groupName">ex group</span> -- <span id="threadName">ex thread</span></h2>
    <div id="posts">
      <div id="examplePost" class="post">
        <div class="metaPost">
          <p>#<span id="postNum">1</span></p>
          <p><span id="posterName">kumbaa3</span></p>
          <p><span id="timeStamp">11/14/13</span></p>
        </div>
        <p class="postBody">This is the main body of the post</p>
        <button class="quoteButton">Quote</button>
      </div>
    </div>
    <button>Reply to this Thread</button>
    <button>Start new Thread</button>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
