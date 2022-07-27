<?php
//function to display users online
function users_online(){
    if (isset($_GET['get-online-users'])) { //catching the get request from ajax(scripts.js)
        global $connection; //this might not work (it was available from the 'includes' in admin header), hence the if statement - kind of redundant code
        if (!$connection){ //checking and establishing db connection, and starting a session
            session_start();
            require_once ("../includes/db.php");

            //is this function calculating time out or giving users 10 seconds to be on the site?
            $session = session_id(); //catching the id of the already started session
            $time = time();
            $time_while_out = 8;
            $time_out = $time - $time_while_out; //time is in seconds i.e. 8 seconds

            //counting the users
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $select_query = mysqli_query($connection, $query);
            $users_online_count = mysqli_num_rows($select_query);

            if ($users_online_count == NULL || $users_online_count == 0) { //this if checks for a new user; inserting fresh data
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else { //this else is for a user who is not new; updating existing data i.e. time
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            //displaying the users online functionality
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            $online_count = mysqli_num_rows($users_online_query);
            echo $online_count;
        }
    }
}
users_online();

//function to confirm query success/failure
function confirmQuery($query_result){
    global $connection;
    if (!$query_result){
        die("Query failed." . mysqli_error($connection));
    }
}

//function to create categories
function create_categories(){
    global $connection;
    //checking for form data
    if(isset($_POST['submit'])){
        //echo "Works just fine.";
        $category_title =  $_POST['category_title'];
        //validating the data
        if ($category_title == "" || empty($category_title)){
            echo "This field should not be empty";
        } else {
            //adding category to database
            $query = "INSERT INTO categories (category_title) VALUES ('{$category_title}')";
            $create_categories = mysqli_query($connection, $query);
            //echo "Data inserted successfully";

            //checking if query was successful
            if (!$create_categories){
                echo die("Data not inserted successfully" . mysqli_error($connection));
            }
        }
    }
}

//function to find and display all categories
function display_categories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    //fetching the categories
    while($row = mysqli_fetch_assoc($select_categories)){
        $category_id = $row['category_id'];
        $category_title = $row['category_title'];

        echo "<tr>";
        echo "<td>{$category_id}</td>";
        echo "<td>{$category_title}</td>";
        //deleting posts link
        echo "<td><a href='categories.php?delete={$category_id}'>Delete</a></td>";
        //editing posts link
        echo "<td><a href='categories.php?edit={$category_id}'>Edit</a></td>";

        echo "</tr>";
    }
}

//function to delete categories
function delete_categories(){
    global $connection;
    //checking for $_GET request
    if (isset($_GET['delete'])){
        $get_category_id = $_GET['delete'];

        //query to delete category from database
        $query = "DELETE FROM categories WHERE category_id = {$get_category_id}";
        $delete_query = mysqli_query($connection, $query);
        //refreshing the page for delete to take effect
        header("Location: categories.php");
    }
}

//function to fix the confirm-form-data-resubmission message
function redirect($location){
   return header("Location: $location");
}

//test function
function test($x,$y){
    return $x * $y;
    //echo "That's right!";
}
