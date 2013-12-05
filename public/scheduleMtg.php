<?php
require_once "auth/cas_init.php";
require_once "classes/group.php";
require_once "classes/user.php";
require_once "login.php";
$group = new Group($_GET["g"]);

include "resources/head.php";?>
<body>
<?php include "resources/topbar.php" ?>
<div id="content">
<?php 
//variablies
$errors='';
$messages='';
$eventName='';
//form
$haveDate=isset($_POST['submit']);
if ($haveDate)
{
	$month=date('m',strtotime($month));
	$day=$_POST["day"];
	$year=$_POST["year"];
	$day=$_POST["day"];
	$eventName=$_POST["eventName"];
	$hour=$_POST["time"];

	//validate date and check for empty fields
	$valiDate=checkdate($month,$day,$year);
	if(!checkdate($month,$day,$year))$errors.="<li>Please enter a valid date.</li>";
	if($eventName=='') $errors.="<li>Please enter a name for the event.</li>";
	if($errors=='')
	{
		$query=$db->prepare("INSERT INTO `group_meetings` (`groupid`,`name`,`year`,`month`,`day`,`hour`)
			VALUES (:groupid, :eventName, :year,:month,:day,:hour)");
        $query->execute(array(':groupid'=>$group->id(),
        					  ':eventName'=>$eventName,
                              ':year'=>$year,
                              ':month'=>$month,
                              ':day'=>$day,
                              ':hour'=>$hour));
        $messages="Event Created.";
	}
	else {?>
		<div id="errors">
			<h3>Error!</h3>
			<ul><?php echo $errors; ?></ul>
		</div>
	<?php }}?>
	<div id="messages">
		<h3><?php echo $messages; ?></h3>
	</div>
	<form id='addEvent' name='addEvent' action="scheduleMtg.php" method="post">
		<select id='month' name='month'>
			<?php for($i = 1; $i <= 12; $i++):?>
			<option value="<?= $i; ?>"><?= date("F", mktime(0, 0, 0, $i)); ?></option>
			<?php endfor; ?>
		</select>
		<select id='day' name='day'>
			<?php for($i = 1; $i <= 31; $i++) {echo "<option value='$i'>$i</option>";} ?>
		</select>
		<select id='year' name='year'>
			<?php for($i = date('Y'); $i < date('Y')+2; $i++) {echo "<option value='$i'>$i</option>";} ?>
		</select>
		<select id='time' name='time'>
			<?php for($i = 0; $i < 24; $i++): ?>
			<option value="<?= $i; ?>"><?= date("h.iA", strtotime("$i:00")); ?></option>
			<?php endfor; ?>
		</select>
		<input type="text" name="eventName" placeholder="Event Name"/>
	    <input id="submit" type="submit" value="submit" name="submit"/>
	</form>
	<h1><?php echo $msg ?></h1>
	<div id="calendar"></div>
	<script src="js/calendar.js"></script>
</div>
	
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

<?php include "resources/footer.php"; ?>
</body>
</html>