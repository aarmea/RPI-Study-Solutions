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
    `notes` text(1000),
    `isadmin` TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`rcsid`)
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the users table.\n";

  $sql = "INSERT INTO users (rcsid) VALUES ('user1')";
  $dbh->exec($sql);

  $sql = "INSERT INTO users (rcsid) VALUES ('user2')";
  $dbh->exec($sql);

  $sql = "INSERT INTO users (rcsid) VALUES ('user3')";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS `available_times` (
    `rcsid` VARCHAR(10) NOT NULL,
    `year` INT NOT NULL,
    `month` TINYINT NOT NULL,
    `day` TINYINT NOT NULL,
    `hour` TINYINT NOT NULL,
    FOREIGN KEY (`rcsid`) REFERENCES `users`(`rcsid`) 
    ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the available_times table.\n";

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
    FOREIGN KEY (`groupid`) REFERENCES `groups`(`groupid`)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`rcsid`) REFERENCES `users`(`rcsid`)
    ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the group membership table.\n";

    $sql = "CREATE TABLE IF NOT EXISTS `group_meetings` (
    `groupid` INT UNSIGNED NOT NULL,
    `meetingid` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `year` INT(4) NOT NULL,
    `month` INT(2) NOT NULL,
    `day` INT(2) NOT NULL,
    `hour` INT(2) NOT NULL,
    `min` INT(2) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    `is_owner` BOOL DEFAULT FALSE,
    PRIMARY KEY (`meetingid`),
    FOREIGN KEY (`groupid`) REFERENCES `groups`(`groupid`)
    ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB";
  $dbh->exec($sql);
  echo "Successfully created the group meetings table.\n";

  $sql = "CREATE TABLE IF NOT EXISTS `threads` (
  `t_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `threadName` varchar(255) NOT NULL,
  PRIMARY KEY (`t_id`),
  FOREIGN KEY (`group_id`) REFERENCES `groups`(`groupid`)
  ON UPDATE CASCADE ON DELETE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
  $dbh->exec($sql);

  echo "Successfully created the threads table.\n";

  $sql = "CREATE TABLE IF NOT EXISTS `posts` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_id` int(10) unsigned NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postBody` varchar(3000) NOT NULL,
  `postNumInThread` int(10) unsigned NOT NULL,
  PRIMARY KEY (`p_id`),
  FOREIGN KEY (`t_id`) REFERENCES `threads`(`t_id`)
  ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`rcsid`)
  ON UPDATE CASCADE ON DELETE CASCADE,
  KEY `user_id` (`user_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
  $dbh->exec($sql);

  echo "Successfully created the posts table.\n";

} catch (PDOException $e) {
  exit("Database error:\n" . $e->getMessage());
}

echo "Installation succeeded.";
?>
