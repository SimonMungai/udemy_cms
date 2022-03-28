<?php
//include "../includes/db.php";
if (isset($_POST['create_user'])){
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];

    //using the $_FILE super global & temporary location (temp/tmp) to upload image to the server
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];

    $user_role = $_POST['user_role'];
    $date_created = date('d-m-y');

    //function to upload image to server (not database yet)
    move_uploaded_file($user_image_tmp, "../images/$user_image");

    //query to insert into posts
    $query ="INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_image, 
                  user_role, date_created) 
                  VALUES ('$username', '$user_password', '$user_firstname', '$user_lastname', '$user_email', '$user_image', 
                          '$user_role', now())";

    //sending to database
    $create_user_query = mysqli_query($connection, $query);

    //confirming if everything went well
    confirmQuery($create_user_query);

    if (!$create_user_query){
        die("something is not right!");
    } else echo "User created: " . "" . "<a href='users.php'> View Users </a>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
            <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_email">Email Address</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_image">Profile Image</label>
        <input type="file" name="user_image">
    </div>

    <div class="form-group">
        <label for="user_role">User role</label>
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Publish Post" name="create_user">
    </div>

</form>
