<?
require_once "config.php";
echo "<html><pre>";

try {
  $conn = new PDO("mysql:host=$DB_HOST", $DB_USERNAME, $DB_PASSWORD);
  echo "Successfully connected to the database server.\n";

  $conn->exec("DROP DATABASE $DB_NAME");
  echo "Successfully deleted database $DB_NAME.\n";
} catch (PDOException $e) {
  exit("Database error:\n" . $e->getMessage());
}

?>
