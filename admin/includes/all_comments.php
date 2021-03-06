<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Disapprove</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        $query = "SELECT * FROM comments";
        $select_comments = mysqli_query($connection, $query);

        //fetching rows from the database
        while ($row = mysqli_fetch_assoc($select_comments)){
            $comment_id = $row['comment_id'];
                //this $comment_post_id is the $post_id fetched from the url and stored in the comments table
            //it is used to relate the comment to the post it belongs to
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            //making the loop create a new row (with collected data) each time
            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";

            //dynamically displaying the categories
           /* $query = "SELECT * FROM categories WHERE category_id = $post_category_id";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)){
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
                echo "<td>{$category_title}</td>";
            }*/

            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";

            //displaying the post related to  the comment
            //fetching the post title from the database
            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
            $select_post_id_query = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_post_id_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

            }

            echo "<td>{$comment_date}</td>";
            //approve comment link
            echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
            //Disapprove comment link
            echo "<td><a href='comments.php?disapprove=$comment_id'>Disapprove</a></td>";
            //delete link
            echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";

            echo "</tr>";
        }
        ?>
    </tbody>
</table>


<?php
//approve comments functionality
if (isset($_GET['approve'])){
    $the_comment_id = $_GET['approve'];

    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id";
    $approve_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after approve happens
    header("Location:comments.php");

}

//disapprove comments functionality
if (isset($_GET['disapprove'])){
    $the_comment_id = $_GET['disapprove'];

    $query = "UPDATE comments SET comment_status = 'disapproved' WHERE comment_id = $the_comment_id";
    $disapprove_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after disapprove happens
    header("Location:comments.php");

}

//delete comments functionality
if (isset($_GET['delete'])){
    $the_comment_id = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id = $the_comment_id";
    $delete_query = mysqli_query($connection, $query);

    //reloading the page inorder to see the page after delete happens
    header("Location:comments.php");

}
?>
