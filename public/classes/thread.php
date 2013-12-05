<?
require_once "auth/config.php";
require_once "db/init.php";

class Thread {
  private $t_id = -1;
  private $threadname = "";
  private $owner = ""; // String that is the RCSid of the thread creator

  public function __construct($t_id) {
    global $db;
    $query = $db->prepare(
      "SELECT `t_id`, `threadname`, `owner` FROM `threads` WHERE `t_id` = :t_id"
    );
    $query->execute(array(":t_id" => $t_id));
    $thread = $query->fetch();
    if (!$query) return;

    $this->t_id = $t_id;
    $this->threadname = $thread->threadname;
    $this->owner = $thread->owner;
  }

  public function exists() {
    return $this->t_id > 0;
  }

  public function id() {
    return $this->t_id;
  }

  public function name() {
    return $this->threadname;
  }

  public function owner() {
    return $this->owner;
  }
}

function listThreads() {
  global $db; // PDO defined in "db/init.php"
  $threads = array();
  $query = $db->prepare("SELECT `t_id`, `threadname` FROM `threads`");
  $query->execute();
  while ($thread = $query->fetch()) {
    $threads[$thread->threadname] = $thread->t_id;
  }
  return $threads;
}

// Creates a thread with $threadname and adds the provided $members.
function addthread($threadname, $owner) {
  global $db;
  $query = $db->prepare(
    "INSERT INTO `threads` (`threadname`, `owner`) VALUES (:threadname, :owner)"
  );
  $query->execute(array(":threadname" => $threadname, ":owner" => $owner));
  $t_id = $db->lastInsertId("t_id");
  return new Thread($t_id);
}
?>
