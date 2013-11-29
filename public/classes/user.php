<?
require_once "db/init.php";

// TODO: Have this class wrap more functionality
class User {
  private $exists = false;

  public function __construct($rcsid) {
    global $db;
    $query = $db->prepare(
      "SELECT `rcsid` FROM `users`
      WHERE `rcsid` = :rcsid"
    );
    $query->execute(array(":rcsid" => $rcsid));
    $user = $query->fetch();
    if ($user) {
      $exists = true;
    }
  }

  public function exists() {
    return $this->exists;
  }
}
?>
