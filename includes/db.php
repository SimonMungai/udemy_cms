<?php
//connecting to the database
/*$connection = mysqli_connect('localhost', 'root', '', 'cms');
//checking connection
if (!$connection){
    die("Database connection failed" . mysqli_error($connection));
} //else echo "Connection successful";*/

//a more secure way of connecting to the database

//$db is an array, and I am storing the values in it.
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_password'] = "";
$db['db_name'] = "cms";

//using the foreach loop to go through the array and make each value a constant
foreach($db as $key => $value){
    //converting the values into constants
    define(strtoupper($key), $value); //strtoupper() function converters the key into uppercase e.g. db_host to DB_HOST.
}
//connecting to the database using the newly created constants
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//errors above may not be affecting functionality


//checking connection
if (!$connection){
    die("Connection failed" . mysqli_error($connection));
} //else echo "Connection successful";

//another secure way (slightly less secure than the above) is storing the connection values in variables and using the variables with mysqli_connect.
