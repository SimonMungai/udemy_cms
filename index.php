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
                //first way to filter the posts to be displayed i.e. published
                //$query = "SELECT * FROM posts WHERE post_status =  'published'";

                $query = "SELECT * FROM posts";
                $select_posts = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_posts)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    //substr() function truncates the content to the set no. of characters.
                    $post_content = substr($row['post_content'],0,100);
                    $post_status = $row['post_status'];

                    //second way to filter displayed posts i.e. published
                    if ($post_status == 'published'){
                    ?>
                        <!--showing all published-->
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id ?>">
                    <img class="img-responsive" src="images/<?php echo $post_image; //referencing to the image?>"
                         width="300px" height="" alt="">
                </a>
                <hr>
                <p><?php echo $post_content?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">
                    Read More <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

                <hr>
                <?php
                    }
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
