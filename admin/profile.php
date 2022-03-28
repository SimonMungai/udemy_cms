<!--header-->
<?php
include "includes/admin_header.php";
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    include "includes/admin_navigation.php";
    ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        User Profile
                        <small> <?php echo $_SESSION['username'];?> </small>
                    </h1>

                    <?php
                    //code to fetch data from the database to display it at the form during edit
                    //checking for the session
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];

                        //querying the database for the user information
                        $query = "SELECT * FROM users WHERE username = '{$username}'";
                        $select_query = mysqli_query($connection, $query);

                        //fetching user information from the database
                        while ($row = mysqli_fetch_array($select_query)) {
                            $user_id = $row['user_id'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname = $row['user_lastname'];
                            $username = $row['username'];
                            $user_password = $row['user_password'];
                            $user_email = $row['user_email'];
                            $user_image = $row['user_image'];
                            //$user_role = $row['user_role'];
                            $date_created = $row['date_created'];
                        }
                    }

                    //code to update the user information
                    //confirming reception of form data
                    if (isset($_POST['update_profile'])) {
                        $username = mysqli_real_escape_string($connection, $_POST['username']);
                        $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
                        $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
                        $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
                        $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);

                        //using the $_FILE super global & temporary location (temp/tmp) to upload image to the server
                        $user_image = $_FILES['user_image']['name'];
                        $user_image_tmp = $_FILES['user_image']['tmp_name'];

                        //$user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
                        $date_created = date('d-m-y');

                        //function to upload image to server (not database yet)
                        move_uploaded_file($user_image_tmp, "../images/$user_image");

                        //making sure the image field is not empty when not updating it to avoid choosing it again.
                        if (empty($user_image)) {
                            $query = "SELECT * FROM users WHERE username = '$username'";
                            $select_image = mysqli_query($connection, $query);

                            while ($row = mysqli_fetch_assoc($select_image)) {
                                $user_image = $row['user_image'];
                            }
                        }

                        //updating user information
                        $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', username = '{$username}', 
                 user_password = '{$user_password}', user_email = '{$user_email}', user_image = '{$user_image}' WHERE username = '{$username}'";
                        $update_profile = mysqli_query($connection, $query);

                        //confirming query success
                        if (!$update_profile) {
                            die("There seems to be an error. Please try again later." . mysqli_error($connection));
                        } else echo "Profile details updated successfully.";
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
                            <input type="submit" class="btn btn-primary" value="Update profile" name="update_profile">
                        </div>

                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!--footer-->
<?php
include "includes/admin_footer.php";
?>


