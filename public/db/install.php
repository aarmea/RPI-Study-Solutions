<?php
require_once "config.php";
echo "<html><pre>";

try {
  $dbh = new PDO("mysql:host=$DB_HOST", $DB_USERNAME, $DB_PASSWORD);
  echo "Successfully connected to the database server\n";

  $dbh->exec("CREATE DATABASE if not exists `$DB_NAME`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;")
  or die(print_r($dbh->errorInfo(), true));
} catch (PDOException $e) {
  die("DB ERROR: ". $e->getMessage());
}

$sql = "USE $DB_NAME";
$dbh->exec($sql);
echo "Successfully created database $DB_NAME.\n";

$sql = "CREATE TABLE IF NOT EXISTS `users` (
  `rcsid` VARCHAR(10) NOT NULL,
  `fname` VARCHAR(100) NOT NULL,
  `lname` VARCHAR(100) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`rcsid`)
  ) ENGINE=InnoDB";
$dbh->exec($sql);
echo "Successfully created the users table.\n";

/*
$sql = "CREATE TABLE IF NOT EXISTS `groups` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`g_id`),
  KEY `owner_id` (`owner_id`),
  KEY `g_id` (`g_id`)
  ) ENGINE=InnoDB";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS `posts` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postBody` varchar(3000) NOT NULL,
  `postNumInThread` int(10) unsigned NOT NULL,
  PRIMARY KEY (`p_id`),
  KEY `t_id` (`t_id`),
  KEY `user_id` (`user_id`)
  ) ENGINE=InnoDB";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS `threads` (
  `t_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `threadName` varchar(255) NOT NULL,
  PRIMARY KEY (`t_id`),
  KEY `group_id` (`group_id`)
  ) ENGINE=InnoDB";
$dbh->exec($sql);

$sql = "ALTER TABLE `groups`
ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`)";
$dbh->exec($sql);

$sql = "ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `threads` (`t_id`),
ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)";
$dbh->exec($sql);

$sql = "ALTER TABLE `threads`
ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`g_id`)";
$dbh->exec($sql);
 */

echo "Installation succeeded.";
?>
