<?
require_once "auth/config.php";
require_once "db/init.php";

class Post {
  private $postid = -1;
  private $threadid = -1;
  private $userid = ""; // String that is the RCSid of the poster
  private $timeStamp = "";
  private $postBody = "";
  private $postNumInThread = "";

  public function __construct($postid) {
    global $db;
    $query = $db->prepare(
      "SELECT `postid`, `threadid`, `userid`, `timeStamp`, `postBody`, `postNumInThread` FROM `posts` WHERE `postid` = :postid"
    );
    $query->execute(array(":postid" => $postid));
    $thread = $query->fetch();
    if (!$query) return;

    $this->postid = $postid;
    $this->threadid = $thread->threadid;
    $this->userid = $thread->userid;
    $this->timeStamp = $thread->timeStamp;
    $this->postBody = $thread->postBody;
    $this->postNumInThread = $thread->postNumInThread;
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

  public function getpostNumInThread(){
    return $this->postNumInThread;
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
  $postNumInThread = -1;
  $query = $db->prepare("SELECT MAX(`postNumInThread`) FROM `posts` WHERE `t_id` = :threadid");
  $query->execute(array(":threadid" => $threadid));
  $postNumInThread = $query->fetch() + 2;
  $query = $db->prepare(
    "INSERT INTO `posts` (`t_id`, `user_id`, `postBody`, `postNumInThread`) VALUES (:threadid, :userid, :postBody, :postNumInThread)"
  );
  $query->execute(array(":threadid" => $threadid, ":userid" => $poster, ":postBody" => $postBody, ":postNumInThread" => $postNumInThread));

  // $postid = $db->lastInsertId("postid");
  // return new Thread($postid);
}
?>
