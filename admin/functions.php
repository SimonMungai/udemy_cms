<?php
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
