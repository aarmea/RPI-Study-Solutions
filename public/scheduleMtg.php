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

<form id="mainForm" method="post" action="scheduleMtg.php?g=<?=$_GET["g"]?>">
	<div class="formData">
	<select name='month' id='month'>
		<?php for($i = 1; $i <= 12; $i++):?>
		<option value="<?= $i; ?>"><?= date("F", mktime(0, 0, 0, $i)); ?></option>
		<?php endfor; ?>
	</select>
	<select name='day' id='day'>
		<?php for($i = 1; $i <= 31; $i++) {echo "<option value='$i'>$i</option>";} ?>
	</select>
	<select name='year' id='year'>
		<?php for($i = date('Y'); $i < date('Y')+2; $i++) {echo "<option value='$i'>$i</option>";} ?>
	</select>
	<select name='time' id='time'>
	<?php 
	?>
	</select>
	<input type="text" name="eventName" placeholder="Event Name"/>
    <input id="submit" type="submit" value="submit" id="submit" name="submit"/>
</div>
</form>
<!--
<h2><?php if(isset($_POST['submit'])) {echo $msg; } ?></h2>
-->
A red time in the hour drop down means that somebody in your group is unavailable at that time
<h2 id="submitMessage"></h2>
<div id="calendar"></div>

<script src="js/calendar.js"></script>
	
<script type="text/javascript">
var submitted = false;
var gid = <?php 
						if(isset($_GET["g"]))
						{ 
							echo $_GET["g"]; 
						} 
						else 
						{ 
							echo 0; 
						} 
					?>;

function post_meeting()
{
  if(submitted == true) { return false; }
  submitted = true;

  var form = $("#mainForm").serialize();
  $.ajax({    
        url:'submit_meeting.php?g=' + gid,
        type: 'post',
        data: form,
        success: function(data) 
        {
          $("#submitMessage").html(data);
          submitted = false;
        }
    });

  return false;
}

function fill_dropdown()
{
  var form = $("#mainForm").serialize();
  $.ajax({    
        url:'get_good_dates.php?g=' + gid,
        type: 'post',
        data: form,
        success: function(data) 
        {
        	$("#time").html(data);
        }
    });

  return false;
}
$("#year").change(fill_dropdown);
$("#day").change(fill_dropdown);
$("#month").change(fill_dropdown);
$("#submit").bind('click',post_meeting);
fill_dropdown();
</script>

<div id="debug"></div>

</body>
</html>