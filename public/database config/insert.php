<?php 


   require 'config.php';

   try {
      $conn = new PDO('mysql:host=localhost;dbname=websysfinaldatabase', $config['DB_USERNAME'], $config['DB_PASSWORD']);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




  
  
      $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES ('morrisr2','Robert','Morris', 'morrisr2@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  

      $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES ('norrisr','Robert','Norris','norrisr@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  

      $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES ('richardsd','Denise','Richards', 'richardsd@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  
   $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES ('dudel','Lucky','Dude','dudel@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  

   $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES('morriss2','Stacey','Morris','morriss2@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  

   $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES('lockr','Robert','Lock','lockr@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  

   $newrcd = "INSERT INTO `user`(`rcs`, `fname`, `lname`, `email`) VALUES('pickyd','Dave','Picky','pickyd@rpi.edu')";
      $conn->exec($newrcd);
      printf("Student inserted <br>");
  

   $newrcd = "INSERT INTO `tutor`(`rcs`, `fname`, `lname`, `email`) VALUES('dirkl','Lacy','Dirk','dirkl@rpi.edu')";
      $conn->exec($newrcd);
      printf("Tutor inserted <br>");
  

   $newrcd = "INSERT INTO `tutor`(`rcs`, `fname`, `lname`, `email`) VALUES ('plotr','Richard','Plot','plotr@rpi.edu')";
      $conn->exec($newrcd);
      printf("Tutor inserted <br>");
  

   $newrcd = "INSERT INTO `tutor`(`rcs`, `fname`, `lname`, `email`) VALUES('richb','Bob','Rich','richb@rpi.edu')";
      $conn->exec($newrcd);
      printf("Tutor inserted <br>");
  
  
      $newrcd = "INSERT INTO `groups`(`owner_id`, `groupName`) VALUES (1, 'groupOne!')";
      $conn->exec($newrcd);
      printf("Course inserted <br>");

      $newrcd = "INSERT INTO `groups`(`owner_id`, `groupName`) VALUES (2, 'The Second Group')";
      $conn->exec($newrcd);
      printf("Course inserted <br>");

      $newrcd = "INSERT INTO `groups` (`g_id`, `groupName`, `owner_id`) VALUES
        (1, 'The first group', 1)";
      $conn->exec($newrcd);
      printf("Group inserted <br>");

      $newrcd = "INSERT INTO `threads` (`t_id`, `group_id`, `threadName`) VALUES
        (1, 1, 'This is the First Thread')";
      $conn->exec($newrcd);
      printf("thread inserted <br>");

      $newrcd = "INSERT INTO `posts` (`p_id`, `t_id`, `user_id`, `time`, `postBody`, `postNumInThread`) VALUES
        (1, 1, 1, '2013-11-21 20:14:52', 'This is the first post for the first thread', 1),
        (2, 1, 2, '2013-11-21 20:50:21', 'I''m responding to the first post. Making this the second post', 2)";
      $conn->exec($newrcd);
      printf("Posts added <br>");
        
  }
  catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }


 ?>