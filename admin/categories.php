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
                        Categories
                        <small><?php echo $_SESSION['username'];?></small>
                    </h1>
                    <!--Adding category form on the left-->
                    <div class="col-xs-6">
                        <!--Add category form-->
                        <form action="" method="post">
                            <?php
                            //calling the function to create categories
                            create_categories();
                            ?>
                            <div class="form-group">
                                <label for="category-title">Categories</label>
                                <input class="form-control" type="text" name="category_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Add Category" name="submit">
                            </div>

                        </form>

                        <!--Update category-->
                        <?php
                        if (isset($_GET['edit'])){
                            $category_id = $_GET['edit'];

                            include "includes/update_categories.php";
                        }
                        ?>

                    </div>

                    <!--categories table on the right-->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                            </tr>
                            </thead>
                            <tbody>

                            <!--displaying categories-->
                            <?php
                            display_categories();
                            ?>

                            <!--delete categories-->
                            <?php
                            delete_categories();
                            ?>
                            </tbody>
                        </table>
                    </div>
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


