<?php
include "../includes/db.php";
if (isset($_POST['create_post'])){
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category'];
    $post_author = $_POST['post_author'];
    $post_status = $_POST['post_status'];

    //using the $_FILE super global & temporary location (temp/tmp) to upload image to the server
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
    //$post_comments_count = 4;

    //function to upload image to server (not database yet)
    move_uploaded_file($post_image_tmp, "../images/$post_image");

    //query to insert into posts
    $query ="INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, 
                  post_status) 
                  VALUES ('$post_category_id','$post_title','$post_author',now(),'$post_image','$post_content',
                          '$post_tags','$post_status')";
    //the .= concatenates the two statements as one.

    //sending to database
    $create_post_query = mysqli_query($connection, $query);

    //confirming if everything went well
    confirmQuery($create_post_query);

    //showing notification to confirm post is created, links to view the post and edit post
    $the_post_id = mysqli_insert_id($connection); //mysqli_insert_id function pulls the last created record id from the table
    echo "<p class='bg-success'> Post Created . <a href='../post.php?p_id=$the_post_id'> View post </a> or <a href='posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a> </p>";

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
            <input type="text" class="form-control" name="post_title">
    </div>

    <!--adding the post_category dynamically-->
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <br>
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
        <input type="text" class="form-control" name="post_author">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <br>
        <select name="post_status" id="">
            <option value="draft">Choose status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Publish Post" name="create_post">
    </div>

</form>
