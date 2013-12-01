<?
require_once "auth/config.php";
require_once "db/init.php";

$DIRECTORY_API_URL = "http://rpidirectory.appspot.com/api";
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

function getYogFromClass($class) {
  $currentDate = new DateTime;
  $yog = (int)$currentDate->format("Y");
  if ((int)$currentDate->format("m") > 5) {
    $yog += 1;
  }
  switch($class) {
  case "first-year student":
    $yog += 3;
    break;
  case "sophomore":
    $yog += 2;
    break;
  case "junior":
    $yog += 1;
    break;
  case "senior":
    break;
  }
  return $yog;
}

function addUserFromDirectory($rcsid) {
  global $db; // PDO defined in "db/init.php"
  global $DIRECTORY_API_URL;

  // Request from the RPI Directory app
  // See https://github.com/jewishdan18/RPI-Directory/wiki/API-Documentation
  $directoryResponse = json_decode(
    file_get_contents("$DIRECTORY_API_URL?q=$rcsid"));

  $query = $db->prepare(
    "INSERT INTO `users` (`rcsid`, `shortname`, `fullname`, `yog`, `major`)
    VALUES (:rcsid, :shortname, :fullname, :yog, :major)"
  );
  foreach ($directoryResponse->data as $user) {
    // Only accept an exact match
    if ($user->rcsid != $rcsid) continue;

    $query->execute(array(
      ":rcsid" => $user->rcsid,
      ":shortname" => ucwords($user->first_name),
      ":fullname" => $user->name,
      ":yog" => getYogFromClass($user->year),
      ":major" => ucwords($user->major)
    ));

    break;
  }

  return new User($rcsid);
}
?>
