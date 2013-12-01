<?
require_once "auth/config.php";
require_once "db/init.php";

$IMAGE_API_URL = "http://www.gravatar.com/avatar";

class User {
  private $exists = false;
  private $rcsid = "";
  private $shortname = "";
  private $fullname = "";
  private $altEmail = "";
  private $yog = -1;
  private $major = "";

  public function __construct($rcsid) {
    global $db;
    $query = $db->prepare(
      "SELECT `rcsid`, `shortname`, `fullname`, `email`, `yog`, `major`
      FROM `users` WHERE `rcsid` = :rcsid"
    );
    $query->execute(array(":rcsid" => $rcsid));
    $user = $query->fetch();
    if (!$user) return;

    $exists = true;
    $this->rcsid = $rcsid;
    $this->shortname = $user->shortname;
    $this->fullname = $user->fullname;
    $this->altEmail = $user->email;
    $this->yog = $user->yog;
    $this->major = $user->major;
  }

  public function exists() {
    return $this->exists;
  }

  public function username() {
    return $this->rcsid;
  }

  public function shortname() {
    return $this->shortname;
  }

  public function fullname() {
    return $this->fullname;
  }

  public function altEmail() {
    return $this->altEmail;
  }

  public function yog() {
    return $this->yog;
  }

  public function major() {
    return $this->major;
  }

  // Returns the email associated with this user's CAS credentials.
  public function casEmail() {
    global $CAS_EMAIL_HOST;
    return $this->rcsid . "@" . $CAS_EMAIL_HOST;
  }

  // Returns the Gravatar image URL for this user.
  // See https://en.gravatar.com/site/implement/hash/
  public function imageURL($size = 200) {
    global $IMAGE_API_URL;
    $email = ($this->email) ? $this->email : $this->casEmail();
    $hash = md5(strtolower(trim($email)));
    return "$IMAGE_API_URL/$hash?s=$size&d=identicon";
  }
}
?>