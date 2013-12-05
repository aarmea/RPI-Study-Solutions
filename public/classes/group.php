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
      "SELECT `rcsid`, `fullname`, `is_owner`
      FROM `group_members` NATURAL JOIN `users`
      WHERE `groupid` = :groupid"
    );
    $query->execute(array(":groupid" => $groupid));
    while ($member = $query->fetch()) {
      if ($member->is_owner) {
        $this->owners[$member->rcsid] = $member->fullname;
      }
      $this->members[$member->rcsid] = $member->fullname;
    }
  }

  public function exists() {
    return $this->groupid > 0;
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

  function addMember($member)
  {
    global $db;

    $query = $db->prepare("SELECT COUNT(*) FROM group_members WHERE groupid=:groupid AND rcsid=:member");
    $query->execute(array(
      ":groupid" => $this->groupid,
      ":member" => $member
      ));

    $result = $query->fetchColumn();


    if($result == 0)
    {
      $query = $db->prepare(
        "INSERT INTO `group_members` (`groupid`, `rcsid`, `is_owner`) VALUES (:groupid, :rcsid, :is_owner)");

      try
      {
        $query->execute(array(
          ":groupid" => $this->groupid,
          ":rcsid" => $member,
          ":is_owner" => false
        ));
      }
      catch(Exception $e)
      {
        return "Could not add the user: User ID does not exist";
      }
      return "Successfully added user $member";
    }
    else
    {
      return "Could not add the user: Already in group";
    }

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
