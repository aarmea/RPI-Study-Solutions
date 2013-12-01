<?php
require_once "config.php";
echo "<html><pre>";

try {
  $dbh = new PDO("mysql:host=$DB_HOST", $DB_USERNAME, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Successfully connected to the database server\n";

  $dbh->exec("CREATE DATABASE if not exists `$DB_NAME`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;")
  or die(print_r($dbh->errorInfo(), true));
} catch (PDOException $e) {
  die("DB ERROR: ". $e->getMessage());
}

try {
  $sql = "USE $DB_NAME";
  $dbh->exec($sql);
  echo "Successfully created database $DB_NAME.\n";

  $sql = "CREATE TABLE IF NOT EXISTS `users` (
    `rcsid` VARCHAR(10) NOT NULL,
    `shortname` VARCHAR(64) NOT NULL,
    `fullname` VARCHAR(64) NOT NULL,
    `email` VARCHAR(256),
    `yog` YEAR,
    `major` VARCHAR(64),
    PRIMARY KEY (`rcsid`)
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the users table.\n";

  $sql = "CREATE TABLE IF NOT EXISTS `groups` (
    `groupid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `groupname` varchar(255) NOT NULL,
    PRIMARY KEY (`groupid`)
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the groups table.\n";

  $sql = "CREATE TABLE IF NOT EXISTS `group_members` (
    `groupid` INT UNSIGNED NOT NULL,
    `rcsid` VARCHAR(10) NOT NULL,
    `is_owner` BOOL DEFAULT FALSE,
    PRIMARY KEY (`groupid`),
    FOREIGN KEY (`groupid`) REFERENCES `groups`(`groupid`)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`rcsid`) REFERENCES `users`(`rcsid`)
    ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the group membership table.\n";

  /*
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

  $sql = "ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `threads` (`t_id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)";
  $dbh->exec($sql);

  $sql = "ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`g_id`)";
  $dbh->exec($sql);
   */
} catch (PDOException $e) {
  exit("Database error:\n" . $e->getMessage());
}

echo "Installation succeeded.";
?>
