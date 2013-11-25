<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dynamic Image Menu Example</title>
<link href="roughcsssheet1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script><script type="text/javascript" src="js/jquery-easing-1.3.pack.js"></script><script type="text/javascript" src="js/jquery-easing-compatibility.1.2.pack.js"></script>
<script type="text/javascript" src="js/jquery.kwicks-1.5.1.pack.js"></script>

<!--[if IE]>
<script type="text/javascript">
$().ready(function() {
  $(".jimgMenu ul").kwicks({max: 310, duration: 400, easing: "easeOutQuad"});
});
</script> 
<![endif]-->
<script type="text/javascript">
$().ready(function() {
  $('.jimgMenu ul').kwicks({max: 310, duration: 300, easing: 'easeOutQuad'});
  });
</script>
</head>
<body>

<div class="jimgMenu">
  <ul>
    <li id="logo"><a href="#nogo">Campus</a></li>
    <li id="people"><a href="#nogo">Yolo</a></li>
    <li id="post"><a href="#nogo">Nature</a></li>
    <li id="explore"><a href="#nogo">Abstract</a></li>
    <li id="profile"><a href="#nogo">Urban</a></li>
    <li id="setting"><a href="#nogo">Urban</a></li>
    <li id="login"><a href="#nogo">Urban</a></li>
  </ul>
</div>
<br  style="clear:both"/><br />

</body>
</html>
