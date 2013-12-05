<?php include "resources/head.php";?>
<body>
<?php include "resources/topbar.php" ?>
<div id="content">
<form>
	<select id='month'>
		<?php for($i = 1; $i <= 12; $i++):?>
		<option value="<?= $i; ?>"><?= date("F", mktime(0, 0, 0, $i)); ?></option>
		<?php endfor; ?>
	</select>
	<select id='day'>
		<?php for($i = 1; $i <= 31; $i++) {echo "<option value='$i'>$i</option>";} ?>
	</select>
	<select id='time'>
	<?php for($i = 0; $i < 24; $i++): ?>
	    <option value="<?= $i; ?>"><?= date("h.iA", strtotime("$i:00")); ?></option>
	<?php endfor; ?>
	</select>
	<input type="text" name="event_name" placeholder="Event Name"/>
    <input type="submit" name="submit_meeting" value="Submit" />
</form>
<div id="calendar"></div>
<script src="js/calendar.js"></script>
</body>
</html>