<?php
//include "../includes/db.php";

//catching the id from the url
if (isset($_GET['edit_user'])){
    $the_user_id = $_GET['edit_user'];

    //fetching data from the database
$query = "SELECT * FROM users WHERE user_id = $the_user_id";
$select_users = mysqli_query($connection, $query);

//fetching rows from the database
while ($row = mysqli_fetch_assoc($select_users)) {
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];
    $date_created = $row['date_created'];
}
}

//confirming form data submission
//updating user data
if (isset($_POST['edit_user'])){
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);

    //using the $_FILE super global & temporary location (temp/tmp) to upload image to the server
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];

    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
    $date_created = date('d-m-y');

    //function to upload image to server (not database yet)
    move_uploaded_file($user_image_tmp, "../images/$user_image");

    //making sure the image field is not empty when not updating it to avoid choosing it again.
    if (empty($user_image)){
        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_image)){
            $user_image = $row['user_image'];
        }
    }

    //fetching randsalt default value from database
    $query = "SELECT randsalt FROM users";
    $select_query = mysqli_query($connection, $query);
    confirmQuery($select_query);
    //encrypting password
    $row = mysqli_fetch_array($select_query);
    $salt = $row['randsalt'];
    $encrypted_password = crypt($user_password, $salt);

    //query to update table records
    $query ="UPDATE users SET username = '{$username}', user_password = '{$encrypted_password}', user_firstname = '{$user_firstname}', 
                 user_lastname = '{$user_lastname}', user_email = '{$user_email}', user_image = '{$user_image}', 
                 user_role = '{$user_role}' WHERE user_id = {$the_user_id}";

    //sending to database
    $edit_user_query = mysqli_query($connection, $query);

    //confirming if everything went well
    confirmQuery($edit_user_query);

    if (!$edit_user_query){
        die("something is not right!" . mysqli_error($connection));
    } else echo "User details updated successfully.";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" value="<?php echo $user_firstname?>" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" value="<?php echo $user_lastname?>" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_email">Email Address</label>
        <input type="email" class="form-control" value="<?php echo $user_email?>" name="user_email">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" value="<?php echo $username?>" name="username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" value="<?php echo $user_password?>" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_image">Profile Image</label>
        <?php echo $user_image?>
        <input type="file" value="<?php echo $user_image?>" name="user_image">
    </div>

    <div class="form-group">
        <label for="user_role">User role</label>
        <select name="user_role" id="">
            <option value="<?php echo $user_role?>"><?php echo $user_role?></option>
            <!--displaying options to change user role to-->
            <?php
            if ($user_role == 'admin'){
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Edit User" name="edit_user">
    </div>

</form>
