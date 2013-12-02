<?
require_once "auth/config.php";
require_once "db/init.php";

class Post {
  private $postid = -1;
  private $threadid = -1;
  private $userid = ""; // String that is the RCSid of the poster
  private $timeStamp = "";
  private $postBody = "";
  private $postNumber = "";

  public function __construct($postid) {
    global $db;
    $query = $db->prepare(
      "SELECT `postid`, `threadid`, `userid`, `timeStamp`, `postBody`, `postNumber` FROM `posts` WHERE `postid` = :postid"
    );
    $query->execute(array(":postid" => $postid));
    $thread = $query->fetch();
    if (!$query) return;

    $this->postid = $postid;
    $this->threadid = $thread->threadid;
    $this->userid = $thread->userid;
    $this->timeStamp = $thread->timeStamp;
    $this->postBody = $thread->postBody;
    $this->postNumber = $thread->postNumber;
  }

  public function exists() {
    return $this->postid > 0;
  }

  public function id() {
    return $this->postid;
  }

  public function threadid(){
    return $this->threadid;
  }

  public function poster() {
    return $this->userid;
  }

  public function getTime(){
    return $this->timeStamp;
  }

  public function getBody(){
    return $this->postBody;
  }

  public function getPostNumber(){
    return $this->postNumber;
  }  
}

function arrayOfPosts($threadid) {
  global $db; // PDO defined in "db/init.php"
  $posts = array();
  $query = $db->prepare(
    "SELECT `postid` FROM `posts` WHERE `threadid` = :threadid"
  );
  $query->execute(array(":threadid" => $threadid));
  $count = 0;
  while ($post = $query->fetch()) {
    $threads[$count] = Post($post['postid']);
    ++$count;
  }
  return $threads;
}

function addPost($threadid, $poster, $postBody) {
  global $db;
  $postNumber = -1;

  $query = $db->prepare("SELECT MAX(`postNumber`) FROM `groups` WHERE `threadid` = :threadid");
  $query->execute(array(":threadid" => $threadid));
  $postNumber = $query->fetch()['postNumber'] + 1;

  $query = $db->prepare(
    "INSERT INTO `posts` (`threadid`, `userid`, `postBody`, `postNumber`) VALUES (:threadname, :userid, :postBody, :postNumber)"
  );
  $query->execute(array(":threadid" => $threadid, ":userid" => $userid, ":postNumber" => $postNumber));
  $postid = $db->lastInsertId("postid");
  return new Thread($postid);
}
?>
