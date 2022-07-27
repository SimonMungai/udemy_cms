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

            //catching the p_id & author
            if (isset($_GET['p_id'])){
                $the_post_id = $_GET['p_id'];
                $the_post_author = $_GET['author'];
            }

            //fetching data from the database
            $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
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
                    By <?php echo $post_author?>
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


            <!-- Posted Comments -->
            <!--query to display approved comments-->
            <h3> Comments </h3>
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
