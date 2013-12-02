<?
require_once "auth/config.php";
require_once "db/init.php";

class Thread {
  private $threadid = -1;
  private $threadname = "";
  private $owner = ""; // String that is the RCSid of the thread creator

  public function __construct($threadid) {
    global $db;
    $query = $db->prepare(
      "SELECT `threadid`, `threadname`, `owner` FROM `groups` WHERE `threadid` = :threadid"
    );
    $query->execute(array(":threadid" => $threadid));
    $thread = $query->fetch();
    if (!$query) return;

    $this->threadid = $threadid;
    $this->threadname = $thread->threadname;
    $this->owner = $thread->owner;
  }

  public function exists() {
    return $this->threadid > 0;
  }

  public function id() {
    return $this->threadid;
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
  $query = $db->prepare("SELECT `threadid`, `threadname` FROM `threads`");
  $query->execute();
  while ($thread = $query->fetch()) {
    $threads[$thread->threadname] = $thread->threadid;
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
  $threadid = $db->lastInsertId("threadid");
  return new Thread($threadid);
}
?>
