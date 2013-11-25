<?
// Install using PEAR, see
// https://wiki.jasig.org/display/CASC/phpCAS+installation+guide
require_once "CAS.php";

require_once "config.php";

// TODO: Switch this off for production
phpCAS::setDebug();

phpCAS::client(CAS_VERSION_2_0, $CAS_HOST, $CAS_PORT, $CAS_URI);
phpCAS::setCasServerCACert($CAS_CA_CERT_PATH);
phpCAS::forceAuthentication();

?>

<html><pre>
Successful authentication

Username: <?=phpCAS::getUser();?>

phpCAS version: <?=phpCAS::getVersion();?>
</pre></html>
