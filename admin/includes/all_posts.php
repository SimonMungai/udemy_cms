<!--check box functionality-->
<?php
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $valuePostId){
        //echo $checkBoxValue;
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options){
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$valuePostId}";
                $update_publish = mysqli_query($connection, $query);
                confirmQuery($update_publish);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$valuePostId}";
                $update_draft = mysqli_query($connection, $query);
                confirmQuery($update_draft);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$valuePostId}";
                $post_delete = mysqli_query($connection, $query);
                confirmQuery($post_delete);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = '{$valuePostId}'";
                $select_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_query)){
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }

                $query ="INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, 
                  post_status) 
                  VALUES ('$post_category_id','$post_title','$post_author',now(),'$post_image','$post_content',
                          '$post_tags','$post_status')";
                $copy_query = mysqli_query($connection, $query);
                confirmQuery($copy_query);
                break;
        }
    }
}
?>

<form action="" method="post">
    <table class="table table-bordered table-hover">
        <!--bulk options drop-down-->
        <div class="col-xs-4" id="bulkOptionsContainer" style="padding: 0px">
            <select class="form-control" name="bulk_options" id="">
                <option value=""> Select Options </option>
                <option value="published"> Publish </option>
                <option value="draft"> Draft </option>
                <option value="delete"> Delete </option>
                <option value="clone"> Clone </option>
            </select>
        </div>
        <!--apply and add new buttons-->
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post"> Add New </a>
        </div>

        <thead>
        <tr>
            <th><input type="Checkbox" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Post Views</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            $query = "SELECT * FROM posts ORDER BY post_id DESC";
            $select_posts = mysqli_query($connection, $query);

            //fetching rows from the database
            while ($row = mysqli_fetch_assoc($select_posts)){
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comments_count = $row['post_comments_count'];
                $post_date = $row['post_date'];
                $post_views = $row['post_views_count'];

                //making the loop create a new row (with collected data) each time
                echo "<tr>";
                ?>
                <!--checkboxes row-->
                <td><input type='Checkbox' class='checkBoxes' id='selectAllBoxes' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
                <?php
                echo "<td>{$post_id}</td>";
                echo "<td>{$post_author}</td>";
                echo "<td>{$post_title}</td>";

                //dynamically displaying the categories
                $query = "SELECT * FROM categories WHERE category_id = $post_category_id";
                $select_categories_id = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_categories_id)){
                    $category_id = $row['category_id'];
                    $category_title = $row['category_title'];
                    echo "<td>{$category_title}</td>";
                }

                echo "<td>{$post_status}</td>";
                echo "<td><img width='100' height='' src='../images/{$post_image}' alt='image'> </td>";
                echo "<td>{$post_tags}</td>";
                echo "<td>{$post_comments_count}</td>";
                echo "<td>{$post_date}</td>";
                //view post link
                echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                //edit post link
                echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                //delete link - with javascript to confirm action
                echo "<td><a onClick=\"javascript: return confirm('Please confirm delete');\" href='posts.php?delete=$post_id'>Delete</a></td>";
                //reset post_views_count link
                echo "<td><a href='posts.php?reset=$post_id'>{$post_views}</a></td>";

                echo "</tr>";
            }
            ?>

        </tbody>
    </table>
</form>



<?php
//delete posts functionality
if (isset($_GET['delete'])){
    $the_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = $the_post_id";
    $delete_query = mysqli_query($connection, $query);
    header("Location:posts.php");

}

//post views count reset functionality
if (isset($_GET['reset'])){
    $the_post_id = $_GET['reset'];

    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
    $reset_query = mysqli_query($connection, $query);
    header("Location:posts.php");

}
?>
