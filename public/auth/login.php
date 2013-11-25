<?
// Install using PEAR, see
// https://wiki.jasig.org/display/CASC/phpCAS+installation+guide
require_once "CAS.php";

require_once "cas_init.php";

phpCAS::forceAuthentication();

?>

<html><pre>
Successful authentication

Username: <?=phpCAS::getUser();?>

phpCAS version: <?=phpCAS::getVersion();?>
</pre></html>
