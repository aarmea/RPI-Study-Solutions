<?php 


   require 'config.php';

   try {
      $conn = new PDO('mysql:host=localhost;dbname='.$config['DB_DBNAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



/*
  
  
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
      printf("Tutor inserted <br>");*/

      $newrcd = "INSERT INTO `rpi_study_solutions`.`users` (`rcsid`, `shortname`, `fullname`, `email`, `yog`, `major`) VALUES ('kumbaa3', 'Alex', 'Alex Kumbar', 'kumbaa3@rpi.edu', '2016', 'ITWS');";
      $conn->exec($newrcd);
      printf("user inserted <br>");
  
      $newrcd = "INSERT INTO `groups`(`groupName`) VALUES ( 'groupOne!')";
      $conn->exec($newrcd);
      printf("group inserted <br>");

      $newrcd = "INSERT INTO `groups`(`groupName`) VALUES ('The Second Group')";
      $conn->exec($newrcd);
      printf("group inserted <br>");

      $newrcd = "INSERT INTO `threads` (`t_id`, `group_id`, `threadName`) VALUES
        (1, 1, 'This is the First Thread')";
      $conn->exec($newrcd);
      printf("thread inserted <br>");

      $newrcd = "INSERT INTO `rpi_study_solutions`.`posts` (`p_id`, `t_id`, `user_id`, `time`, `postBody`, `postNumInThread`) VALUES (NULL, '1', 'kumbaa3', CURRENT_TIMESTAMP, 'This is the first post for the first thread', '1');";
      $conn->exec($newrcd);
      printf("Posts added <br>");

      $newrcd = "INSERT INTO `rpi_study_solutions`.`posts` (`p_id`, `t_id`, `user_id`, `time`, `postBody`, `postNumInThread`) VALUES (NULL, '1', 'kumbaa3', CURRENT_TIMESTAMP, 'Im talking to myself', '2');";
      $conn->exec($newrcd);
      printf("Posts added <br>");
        
  }
  catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }


 ?>