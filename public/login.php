<?
require_once "classes/user.php";

require_once "db/init.php";
require_once "auth/cas_init.php";

$DIRECTORY_REQUEST_URL = "http://rpidirectory.appspot.com/api?q=";

function getYogFromClass($class) {
  // TODO
  return 2014;
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
      ":major" => $user->major
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
// TODO: Redirect to profile page on success

?>
<?php include "resources/head.php"; ?>
<body>
  <?php include "resources/topbar.php"; ?>
  <div id="content">
    <h2>Welcome, <?=phpCAS::getUser()?></h2>
  </div>
  <?php include "resources/footer.php"; ?>
</body>
</html>
