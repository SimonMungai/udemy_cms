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

                //pagination
                //catching and processing the $_GET request
                $per_page = 2;
                if (isset($_GET['page'])){
                    $page = $_GET['page'];
                } else {
                    $page = "";
                }

                if ($page == "" || $page == 1){
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
                //finding out how many posts there are
                $posts_count_query = "SELECT * FROM posts";
                $select_posts_query = mysqli_query($connection, $posts_count_query);
                $posts_count = mysqli_num_rows($select_posts_query);

                //per-page functionality i.e. specifying how many posts per page
                $posts_count = ceil($posts_count / $per_page); //ceil function rounds off the result into an integer. The result cannot be a float number. There is no a .something post.

                //displaying posts functionality
                //querying the database for posts information
                $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
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
                        <!--<h1><?php /*echo $posts_count */?></h1>-->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author?>&p_id=<?php echo $post_id;?>"><?php echo $post_author?></a>
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

        <!--pagination links-->
        <ul class="pager">
            <?php
            for ($i = 1; $i <= $posts_count; $i++){
                //adding some style to pager numbers
                //determining current page
                if ($i == $page){
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a> </li>";
                } else{
                    echo "<li><a href='index.php?page={$i}'>{$i}</a> </li>";
                }

            }
            ?>
        </ul>


        <!--footer-->
        <?php
        include "includes/footer.php";
        ?>
