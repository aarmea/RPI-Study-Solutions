<?php include "resources/head.php";?>
<body>
<?php include "resources/topbar.php" ?>
<div id="content">
<h1>Schedule Event</h1>
<div id="calendar"></div>
<form method="post" action="">
	<input type="text" name="event_name" />
	<input type="submit" name="submit_meeting" value="Submit Meeting" />
	<div id="timegrid"></div>
</form>
</body>
</html>