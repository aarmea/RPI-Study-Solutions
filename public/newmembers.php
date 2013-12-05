<?php
require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";
$group = new Group($_GET["g"]);
require_once "login.php"
?>
<?php include "resources/head.php";?>
<body>
<?php include "resources/topbar.php" ?>
<div id="content">

<form id="mainForm" method="post" action="newmembers.php?g=<?=$_GET["g"]?>">
  <div class="formData">
  </select>
    <label style="font-size:15px">Add member</label>
    <input type="text" name="name" placeholder="RCS ID"/>
    <input id="submit" type="submit" value="submit" id="submit" name="submit"/>
  </div>
</form>

<?php

  if(isset($_POST['submit']))
  {
    $name = $_POST['name'];

    //Run query to add the member to the group if not exists
    $msg = $group->addMember($name);

    echo $msg;
  }

?>

<?php include "resources/footer.php" ?>