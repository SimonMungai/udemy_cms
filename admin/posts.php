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
                        Posts
                        <small> <?php echo $_SESSION['username'];?></small>
                    </h1>

                    <?php
                    //using the $_GET request to show different functionality depending on certain conditions
                    if(isset($_GET['source'])){
                        $source = $_GET['source'];
                        } else {
                        $source = '';
                        }

                        switch ($source){
                            case 'add_post';
                            include "includes/add_post.php";
                                break;
                            case 'edit_post';
                                include "includes/edit_post.php";
                                break;
                            case 200;
                                echo "nice 200";
                                break;
                            default:
                               include "includes/all_posts.php";
                                break;
                        }
                    ?>
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


