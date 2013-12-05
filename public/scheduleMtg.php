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
<?php 

$haveDate=isset($_POST['submit']);
if ($haveDate)
{
	$month=date('m',strtotime($month));
	$day=$_POST["day"];
	$year=$_POST["year"];
	$day=$_POST["day"];

	//validate date
	$valiDate=checkdate($month,$day,$year);
	if(!$valiDate)$msg="wrongwrong";
	else
	{
		$msg="okay";
		$query=$db->prepare("INSERT INTO `meetings` (`groupid`, `year`,`month`,`day`,`hour`,`min`)
			VALUES (:groupid, :year,:month,:day,:hour,:min)");
        $query->execute(array(':groupid'=>$group->id(),
                              ':year'=>$year,
                              ':month'=>$month,
                              ':day'=>$day,
                              ':hour'=>$_POST['hour'],
                              ':min'=>$_POST['min']));
	}
}
else $msg="not set???"

?>
<form id="mainForm">
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
		//require 'get_good_dates.php';
		/*
		for($i = 0; $i < 24; $i++)
		{
	    echo "<option value=$i>" . date('h.iA', strtotime("$i:00")) . "</option>";
	  }
	  */

	?>
	</select>
	<input type="text" name="eventName" placeholder="Event Name"/>
    <input type="submit" value="submit" id="submit" name="submit"/>
</div>
</form>
<h1><?php echo $msg ?></h1>
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
function fill_dropdown()
{
  if(submitted == true) { return false; }
  submitted = true;

  var form = $("#mainForm").serialize();
  $.ajax({    

        url:'get_good_dates.php?g=' + gid,
        type: 'post',
        data: form,
        success: function(data) 
        {
        	//$("#debug").html(data);
        	$("#time").html(data);
          submitted = false;
        }
    });

  return false;
}
$("#year").change(fill_dropdown);
$("#day").change(fill_dropdown);
$("#month").change(fill_dropdown);
fill_dropdown();
</script>

<div id="debug"></div>

</body>
</html>