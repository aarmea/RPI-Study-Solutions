<?
require_once "classes/user.php";

require_once "db/init.php";
require_once "auth/cas_init.php";

$DIRECTORY_REQUEST_URL = "http://rpidirectory.appspot.com/api?q=";

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
  global $DIRECTORY_REQUEST_URL;

  // Request from the RPI Directory app
  // See https://github.com/jewishdan18/RPI-Directory/wiki/API-Documentation
  $directoryResponse = json_decode(
    file_get_contents($DIRECTORY_REQUEST_URL . $rcsid));

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

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
if (!$client->exists()) {
  $client = addUserFromDirectory(phpCAS::getUser());
}

// TODO: CAS failure condition (we don't have to worry about it so much because
// CAS will not redirect the browser to this page on common failure cases)

// Login (and user creation) successful, so redirect the user to the profile
header("Location: userprofile.php");

?>
