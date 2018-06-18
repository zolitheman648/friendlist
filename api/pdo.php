<?php

  var_dump($_SERVER['REQUEST_METHOD']);

  try
  {
    //open the database
    $db = new PDO('sqlite:users.db');

    //create the database
    /*$db->exec("CREATE TABLE Dogs (Id INTEGER PRIMARY KEY, Breed TEXT, Name TEXT, Age INTEGER)");  */  

    //insert some data...
    /*$db->exec("INSERT INTO Dogs (Breed, Name, Age) VALUES ('Labrador', 'Tank', 2);".
               "INSERT INTO Dogs (Breed, Name, Age) VALUES ('Husky', 'Glacier', 7); " .
               "INSERT INTO Dogs (Breed, Name, Age) VALUES ('Golden-Doodle', 'Ellie', 4);");*/

    //now output the data to a simple html table...
    print "<table border=1>";
    print "<tr><td>Id</td><td>Name</td><td>Mail</td><td>Service</td></tr>";
    $result = $db->query('SELECT * FROM users');
    foreach($result as $row)
    {
      print "<tr><td>".$row['id']."</td>";
      print "<td>".$row['name']."</td>";
      print "<td>".$row['mail']."</td>";
      print "<td>".$row['service']."</td></tr>";
    }
    print "</table>";

    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
?>