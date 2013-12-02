<?
require_once "auth/config.php";
require_once "db/init.php";

class Group {
  private $groupid = -1;
  private $groupname = "";
  // "Set" of rcsid strings represented as an array, with values stored as keys
  private $members = array();
  private $owners = array(); // Same type as $members

  public function __construct($groupid) {
    global $db;
    $query = $db->prepare(
      "SELECT `groupid`, `groupname` FROM `groups` WHERE `groupid` = :groupid"
    );
    $query->execute(array(":groupid" => $groupid));
    $group = $query->fetch();
    if (!$query) return;

    $this->groupid = $groupid;
    $this->groupname = $group->groupname;

    $query = $db->prepare(
      "SELECT `rcsid`, `is_owner` FROM `group_members`
      WHERE `groupid` = :groupid"
    );
    while ($member = $query->fetch()) {
      if ($member->is_owner) {
        $this->owners[$member->rcsid] = $member->rcsid;
      }
      $this->members[$member->rcsid] = $member->rcsid;
    }
  }

  public function id() {
    return $this->groupid;
  }

  public function name() {
    return $this->groupname;
  }

  public function members() {
    return $this->members;
  }

  public function owners() {
    return $this->owners;
  }
}

function listGroups() {
  global $db; // PDO defined in "db/init.php"
  $groups = array();
  $query = $db->prepare("SELECT `groupid`, `groupname` FROM `groups`");
  $query->execute();
  while ($group = $query->fetch()) {
    $groups[$group->groupname] = $group->groupid;
  }
  return $groups;
}

// Creates a group with $groupname and adds the provided $members. The first
// listed member is made the owner of the group.
function addGroup($groupname, $members = array()) {
  global $db;
  $query = $db->prepare(
    "INSERT INTO `groups` (`groupname`) VALUES (:groupname)"
  );
  $query->execute(array(":groupname" => $groupname));
  $groupid = $db->lastInsertId("groupid");
  $query = $db->prepare(
    "INSERT INTO `group_members` (`groupid`, `rcsid`, `is_owner`)
    VALUES (:groupid, :rcsid, :is_owner)"
  );
  $index = 0;
  foreach ($members as $member) {
    $query->execute(array(
      ":groupid" => $groupid,
      ":rcsid" => $member,
      ":is_owner" => ($index == 0)
    ));
    ++$index;
  }
  return new Group($groupid);
}
?>
