<?php session_start() ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!--displaying the categories on the navigation-->
                <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);

                //fetching the categories
                while($row = mysqli_fetch_assoc($select_categories)){
                   $category_title = $row['category_title'];

                   //displaying the categories
                    echo "<li><a href='#'>{$category_title}</a></li>"; //be sure to use double quotes so that a variable is acceptable within the echo
                }
                ?>

                <li>
                    <a href="admin">Admin</a>
                </li>
                <li>
                    <a href="registration.php">Register</a>
                </li>

                <!--edit post link & view all posts-->
                <!--Checking if user is logged in-->
                <?php
                if (isset($_SESSION['user_role'])){
                    if (isset($_GET['p_id'])){
                        $the_post_id = $_GET['p_id'];
                        echo "<li> <a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'> Edit Post </a> </li>";
                        echo "<li> <a href='admin/posts.php?p_id={$the_post_id}'> All Posts </a> </li>";
                    }
                }
                ?>

                <!--<li>
                    <a href="#">Contact</a>
                </li>-->
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
