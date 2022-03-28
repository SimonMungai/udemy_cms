<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Username</th>
        <th>Password</th>
        <th>Email</th>
        <th>Image</th>
        <th>Role</th>
        <th>Date Created</th>
        <th>Make Admin</th>
        <th>Make Subscriber</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        //fetching rows from the database
        while ($row = mysqli_fetch_assoc($select_users)){
            $user_id = $row['user_id'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            $date_created = $row['date_created'];

            //making the loop create a new row (with collected data) each time
            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_password}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_image}</td>";
            echo "<td>{$user_role}</td>";
            echo "<td>{$date_created}</td>";
            //approve comment link
           // echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
            //Disapprove comment link
            //echo "<td><a href='comments.php?disapprove=$comment_id'>Disapprove</a></td>";
            //Change to admin link
            echo "<td><a href='users.php?make_admin=$user_id'>Make admin</a></td>";
            //Change to subscriber link
            echo "<td><a href='users.php?make_subscriber=$user_id'>Make Subscriber</a></td>";
            //edit link
            echo "<td><a href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>";
            //delete link
            echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";

            echo "</tr>";
        }
        ?>
    </tbody>
</table>


<?php
//approve comments functionality
if (isset($_GET['approve'])){
    $the_comment_id = $_GET['approve'];

    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id";
    $approve_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after approve happens
    header("Location:comments.php");

}

//disapprove comments functionality
if (isset($_GET['disapprove'])){
    $the_comment_id = $_GET['disapprove'];

    $query = "UPDATE comments SET comment_status = 'disapproved' WHERE comment_id = $the_comment_id";
    $disapprove_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after disapprove happens
    header("Location:comments.php");

}

//change to admin functionality
if (isset($_GET['make_admin'])){
    $the_user_id = $_GET['make_admin'];

    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";
    $change_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after approve happens
    header("Location:users.php");

}

//change to subscriber functionality
if (isset($_GET['make_subscriber'])){
    $the_user_id = $_GET['make_subscriber'];

    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id";
    $change_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after approve happens
    header("Location:users.php");

}

//delete users functionality
if (isset($_GET['delete'])){
    $the_user_id = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = $the_user_id";
    $delete_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after delete happens
    header("Location:users.php");

}
?>
