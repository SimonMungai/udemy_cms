<!--header-->
<?php include "includes/admin_header.php"; ?>

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
                            Welcome admin
                            <small> <?php echo $_SESSION['username']; ?></small>
                        </h1>

                    </div>
                </div>
                <!-- /.row -->

                <!--widgets-->
                <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!--dynamically displaying number of users-->
                                    <?php
                                    $query = "SELECT * FROM users";
                                    $select_query = mysqli_query($connection, $query);
                                    $users_count = mysqli_num_rows($select_query); //mysqli_num_rows() counts the number of rows.
                                    echo "<div class='huge'> $users_count </div>";
                                    ?>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <!--dynamically displaying number of posts-->
                                            <?php
                                            $query = "SELECT * FROM posts";
                                            $select_query = mysqli_query($connection, $query);
                                            $posts_count = mysqli_num_rows($select_query); //mysqli_num_rows() counts the number of rows.
                                            echo "<div class='huge'> $posts_count </div>";
                                            ?>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <!--dynamically displaying number of comments-->
                                        <?php
                                        $query = "SELECT * FROM comments";
                                        $select_query = mysqli_query($connection, $query);
                                        $comments_count = mysqli_num_rows($select_query); //mysqli_num_rows() counts the number of rows.
                                        echo "<div class='huge'> $comments_count </div>";
                                        ?>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <!--dynamically displaying number of comments-->
                                        <?php
                                        $query = "SELECT * FROM categories";
                                        $select_query = mysqli_query($connection, $query);
                                        $categories_count = mysqli_num_rows($select_query);
                                        echo "<div class='huge'> $categories_count </div>"
                                        ?>

                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!--queries for fetching data from database to be used in displaying data (dynamically) in admin-->
                <?php
                //published posts query
                $query = "SELECT * FROM posts WHERE post_status = 'published'";
                $select_query = mysqli_query($connection, $query);
                $published_posts_count = mysqli_num_rows($select_query);

                //draft posts query
                $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                $select_query = mysqli_query($connection, $query);
                $draft_posts_count = mysqli_num_rows($select_query);

                //disapproved comments query
                $query = "SELECT * FROM comments WHERE comment_status = 'disapproved'";
                $select_query = mysqli_query($connection, $query);
                $disapproved_comments_count = mysqli_num_rows($select_query);

                //subscriber users query
                $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                $select_query = mysqli_query($connection, $query);
                $subscriber_users_count = mysqli_num_rows($select_query);

                ?>

                <!--google chart-->
                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],
                                //Dynamically displaying the data
                                <?php
                                //array to hold the fields
                                $elements_text = ['All Users', 'Subscribers', 'All Posts', 'Draft Posts', 'Published Posts',
                                    'Approved Comments', 'Disapproved Comments', 'Categories'];
                                //array to hold the count data
                                $elements_count = [$users_count, $subscriber_users_count, $posts_count, $draft_posts_count,
                                    $published_posts_count, $comments_count, $disapproved_comments_count, $categories_count];

                                //loop to display array data
                                //the loop initializer '$i' is used to iterate the loop
                                for ($i = 0; $i < 8; $i++){
                                    echo "['{$elements_text[$i]}'" . "," . "{$elements_count[$i]}],";
                                }
                                ?>
                                //static data
                                //['Posts', 6],
                                //['Comments', 8],
                                //['Users', 3],
                                //['Categories', 11],
                            ]);

                            var options = {
                                chart: {
                                    title: '',
                                    subtitle: '',
                                }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>

                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                    
                </div>
                <!--/.google chart-->

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

