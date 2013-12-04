<?php

require_once "db/init.php";
require 'db/config.php';
require_once "auth/cas_init.php";
require_once "classes/user.php";
phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());

$query=$db->prepare("UPDATE `users` SET `notes`=:text WHERE `rcsid`= :username");
$query->execute(array(':username'=>$client->username(),
                      ':text'=>$_POST['notes']));

echo $_POST['notes'];

?>