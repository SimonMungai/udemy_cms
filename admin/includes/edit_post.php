<?php
//fetching post data from the database, to display it on edit_post form
if(isset($_GET['p_id'])){
    $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_posts_by_id = mysqli_query($connection, $query);

//fetching rows from the database
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    //$post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_comments_count = $row['post_comments_count'];
    $post_date = $row['post_date'];
}


//confirming form data submission
//if you get the MySQL syntax error, implement the mysqli_real_escape_string () function to handle special characters like apostrophe
//e.g. $post_author = mysqli_real_string_escape ($connection, $_POST['post_author'])
if (isset($_POST['update_post'])){
    //fetching form data from table - updated data
    $post_author = mysqli_real_escape_string($connection, $_POST['post_author']);
    $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category']);
    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);
    $post_image = $_FILES['post_image'] ['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);

    //moving image from temporary location to permanent location on server
    move_uploaded_file($post_image_tmp, "../images/$post_image");

    //making sure the image field is not empty when not updating it to avoid choosing it again.
    if (empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_image)){
            $post_image = $row['post_image'];
        }
    }

    //the update query
    $query = "UPDATE posts SET post_category_id = '{$post_category_id}', post_title = '{$post_title}',
                 post_author = '{$post_author}', post_date = now(), post_image = '{$post_image}', post_content = '{$post_content}', 
                 post_tags = '{$post_tags}', post_status = '{$post_status}' WHERE post_id = $the_post_id";
    /*$query = "UPDATE posts SET ";
    $query .="post_title = '{$post_title}', ";
    $query .="post_category_id = '{$post_category_id}', ";
    $query .="post_date = now(), ";
    $query .="post_author = '{$post_author}', ";
    $query .="post_status = '{$post_status}', ";
    $query .="post_tags = '{$post_tags}', ";
    $query .="post_content = '{$post_content}', ";
    $query .="post_image = '{$post_image}' ";
    $query .="WHERE post_id = {$the_post_id}";*/


    $update_post = mysqli_query($connection, $query);

    //confirming query success
    //confirmQuery($update_post);
    //or
    //redirecting back to all posts if query is successful
    /*if (!$update_post){
        die("Post editing failed " . mysqli_error($connection));
    } else header("Location: posts.php");*/
    //or
    //showing notification on post update, link to view the post and edit more posts
    echo "<p class='bg-success'> Post Updated . <a href='../post.php?p_id=$the_post_id'> View post </a> or <a href='posts.php'>Edit More Posts</a> </p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
            <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category Id</label>
        <br>
       <!-- <input type="text" class="form-control" name="post_category_id" value="<?php /*echo $post_category_id; */?>">-->
        <!--fetching the category id from DB and displaying it-->
        <select name="post_category" id="">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            //confirming query success
            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];

                echo "<option value='$category_id'>$category_title</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
    </div>


    <!--<div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php /*echo $post_status; */?>">
    </div>-->

    <!--dynamically displaying status and showing edit options-->
    <div class="form-group">
        <select name="post_status" id="">
            <option value='<?php $post_status; ?>'> <?php echo $post_status; ?> </option>
            <?php
            if ($post_status == 'published'){
                echo "<option value='draft'> Draft </option>";
            } else {
                echo "<option value='published'> Published </option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <br>
        <input type="file" name="post_image">
        <img width = 100 src="../images/<?php echo $post_image; ?>" alt="">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"> <?php echo $post_content;?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value=" Update post" name="update_post">
    </div>

</form>
