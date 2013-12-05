<?
require_once "classes/user.php";

require_once "db/init.php";
require_once "auth/cas_init.php";

phpCAS::forceAuthentication();
$client = new User(phpCAS::getUser());
if (!$client->exists()) {
  $client = addUserFromDirectory(phpCAS::getUser());

  // Login (and user creation) successful, so redirect the user to the profile
  header("Location: userprofile.php");
}

// TODO: CAS failure condition (we don't have to worry about it so much because
// CAS will not redirect the browser to this page on common failure cases)


?>
