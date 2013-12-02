<?
// This configuration is valid only for the included Vagrant testing
// environment. For production use, it is highly recommended to create a new
// non-root MySQL user that only has access to $DB_NAME.
$config = array(
   'DB_HOST'     => 'localhost',
   'DB_DBNAME'   => 'rpi_study_solutions',
   'DB_USERNAME' => 'myadmin',
   'DB_PASSWORD' => 'myadmin',
);
date_default_timezone_set("America/New_York");
?>
