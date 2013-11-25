<?php
$host="localhost"; 

require "config.php";

$root= $config['DB_USERNAME']; 
$root_password= $config['DB_PASSWORD']; 

$user='newuser';
$pass='newpass';
$db="websysfinaldatabase"; 

    try {
        $dbh = new PDO("mysql:host=$host", $root, $root_password);

        $dbh->exec("CREATE DATABASE if not exists `$db`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$db`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;") 
        or die(print_r($dbh->errorInfo(), true));

    } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
    }

$sql = "USE websysfinaldatabase";
$dbh->exec($sql);
 
$sql = "CREATE TABLE if not exists tutor (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rcs` varchar(200) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
)";


 $dbh->exec($sql);



$sql = "CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rcs` varchar(200) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB";

$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS `groups` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`g_id`),
  KEY `owner_id` (`owner_id`),
  KEY `g_id` (`g_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2";
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS `threads` (
  `t_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `threadName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`t_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ";
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

 echo "Database created";
?>