<?php include "db.php" ?>
<?php session_start()?>

<?php
//confirming if data is received from form
if (isset($_POST['login'])){
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];

    //cleaning up the data: security to prevent SQL Injection attacks
   $username = mysqli_real_escape_string($connection, $username);
   $user_password = mysqli_real_escape_string($connection, $user_password);

   //querying the database (for specified data)
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_query = mysqli_query($connection, $query);

    //checking for query success
    if (!$select_query){
        die("Something ain't right " . mysqli_error($connection));
    }

    //fetching records from the database
    while($row = mysqli_fetch_array($select_query)){
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }

    //validating the data sent against the data received; logic and action
    /*if ($username !== $db_username && $user_password !== $db_user_password){
        header("Location: ../index.php");
    } else if ($username == $db_username && $user_password == $db_user_password){
        //setting/assigning sessions
        //note: sessions are assigned value from right to left: opposite of variables
        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../admin");
    } else {
        header("Location: ../index.php");
    }*/

    //an easier way to validate login
    if ($username === $db_username && $user_password === $db_user_password) {
        //setting/assigning sessions
        //note: sessions are assigned value from right to left: opposite of variables
        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../admin/index.php");
    } else {
        header("Location: ../index.php");
    }


    /*//my initial trial code
    //fetching records from the database
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_query)){
        $username_1 = $row['username'];
        $user_password_1 = $row['user_password'];
    }

    if ($username == $username_1){
        if ($user_password == $user_password_1){
    echo "Welcome $username";
        } else {
            echo "Wrong password";
        }
    } else{
        echo "Wrong username";
    }*/
}
?>
