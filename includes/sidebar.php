<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control" name="search">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login form -->
    <div class="well">
        <h4>Log in</h4>
        <form action="includes/login.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
            <div class="input-group">
                <input type="password" class="form-control" name="user_password" placeholder="Password">
                <span class="input-group-btn">
                     <button class="btn btn-primary" type="submit" name="login">Log in </button>
                </span>
            </div>
        </form>
    </div>
    <!-- /.input-group -->

    <!-- Blog Categories Well -->
    <div class="well">
        <?php
        $query = "SELECT * FROM categories LIMIT 3"; //LIMIT works to limit the number of results displayed (optional)
        $select_categories_sidebar = mysqli_query($connection, $query);
        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    //fetching the categories
                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                        $category_title = $row['category_title'];
                        $category_id = $row['category_id'];

                        echo "<li><a href='category.php?category=$category_id'>{$category_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php
    include "widget.php";
    ?>

</div>
