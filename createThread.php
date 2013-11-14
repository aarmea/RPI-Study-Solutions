<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>Create Thread</h2>
    <form>
      <label>Topic:</label>
      <select>
        <option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="opel">Opel</option>
        <option value="audi">Audi</option>
      </select>
      <label>Thread Name:</label>
      <input type="text" name="threadName">
      <label>Post Body:</label>
      <textarea cols="40" rows="5" name="myname"> Now we are inside the area - which is nice. </textarea>
    </form>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
