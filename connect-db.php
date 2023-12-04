<?php

$servername = "localhost";
$username = "id21602497_user1";
$password = "Password1!";
$database = "id21602497_proj_db";

/** connect to the database **/
try 
{
//  $db = new PDO("mysql:host=$hostname;dbname=db-demo", $username, $password);
   $db = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
   
   // dispaly a message to let us know that we are connected to the database 
   //echo "<p>You are connected to the database!</p>";
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   // Call a method from any object, use the object's name followed by -> and then method's name
   // All exception objects provide a getMessage() method that returns the error message 
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>