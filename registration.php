<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<!--registration form functionality-->
<?php
if (isset($_POST['submit'])){

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    //validating fields
    if (!empty($username) && !empty($user_email) && !empty($user_password)) {

        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);

        /*//querying database for randsalt value/checking for default value
        $query = "SELECT randsalt FROM users";
        $select_query = mysqli_query($connection, $query);
        confirmQuery($select_query);*/

        /*while($row = mysqli_fetch_array($select_query)){
            echo $salt = $row['randsalt'];
        }*/

        /*//encrypting
        $row = mysqli_fetch_array($select_query);
        $salt = $row['randsalt'];
        $user_password = crypt($user_password, $salt);*/

        //a new and simpler way of encrypting
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

        //query to insert values into database
        $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$user_email}', '{$user_password}', 'subscriber')";
        $register_query = mysqli_query($connection, $query);
        if (!$register_query) {
            die("Query failed" . mysqli_error($connection) . '' . mysqli_errno($connection));
        } else $message = "Registration successful";

    } else $message = "Fields cannot be empty";

} else $message = ""; //prevents the error when submit is not clicked e.g. when page is first loaded, when page is refreshed etc.
?>
    
<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message; ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="user_email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="user_password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
