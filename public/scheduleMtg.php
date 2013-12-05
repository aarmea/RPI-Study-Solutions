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
<form>
	<div class="formData">
	<select id='month'>
		<?php for($i = 1; $i <= 12; $i++):?>
		<option value="<?= $i; ?>"><?= date("F", mktime(0, 0, 0, $i)); ?></option>
		<?php endfor; ?>
	</select>
	<select id='day'>
		<?php for($i = 1; $i <= 31; $i++) {echo "<option value='$i'>$i</option>";} ?>
	</select>
	<select id='year'>
		<?php for($i = date('Y'); $i < date('Y')+2; $i++) {echo "<option value='$i'>$i</option>";} ?>
	</select>
	<select id='time'>
	<?php for($i = 0; $i < 24; $i++): ?>
	    <option value="<?= $i; ?>"><?= date("h.iA", strtotime("$i:00")); ?></option>
	<?php endfor; ?>
	</select>
	<input type="text" name="eventName" placeholder="Event Name"/>
    <input type="submit" value="submit" id="submit" name="submit"/>
</div>
</form>
<h1><?php echo $msg ?></h1>
<div id="calendar"></div>
<script src="js/calendar.js"></script>
</body>
</html>