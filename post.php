<!--header-->
<?php
include "includes/db.php";
include "includes/header.php";
?>

<!--body-->

<!-- Navigation -->
<?php include "includes/navigation.php"?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            //catching the p_id
            if (isset($_GET['p_id'])){
                $the_post_id = $_GET['p_id'];
            }

            //fetching data from the database
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            $select_posts = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_posts)){
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];

                ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; //referencing to the image?>" width="300" alt="">
                <hr>
                <p><?php echo $post_content?></p>
                <!--<a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>-->

                <hr>
                <?php
            }
            ?>


            <!-- Blog Comments -->
            <!--code to insert comment to database-->
            <?php
            if(isset($_POST['create_comment'])){

                //catching the post_id from the url
                $the_post_id = $_GET['p_id'];

                //catching $_POST data
                $comment_author = $_POST['comment_author'];
                $comment_email  = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                //form data validation
                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                //query to insert into database
                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) 
VALUES($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";

                $create_comment_query = mysqli_query($connection, $query);

                if (!$create_comment_query){
                    die("Sorry, something is not right " . mysqli_error());
                } else echo "Comment submitted successfully";

                //updating the post_comments_count
                $query = "UPDATE posts SET post_comments_count = post_comments_count + 1 WHERE post_id = $the_post_id";
                $update_comment_count_query = mysqli_query($connection, $query);

                } else {
                    echo "<script>alert('Fields cannot be empty')</script>";
                }
            }
            ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your thoughts, please</label>
                        <textarea class="form-control" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>
            <hr>

            <!-- Posted Comments -->
            <!--query to display approved comments-->
            <?php
            $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} 
                         AND comment_status = 'approved' ORDER BY comment_id DESC";

            $select_comment_query = mysqli_query($connection, $query);
            if (!$select_comment_query){
                die("Could not display comments" . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_array($select_comment_query)){
                $comment_author = $row['comment_author'];
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];

            ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

            <?php
            }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <!--footer-->
    <?php
    include "includes/footer.php";
    ?>
