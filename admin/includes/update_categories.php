<form action="" method="post">
    <div class="form-group">
        <label for="category-title">Edit Category</label>
        <?php
        if (isset($_GET['edit'])){

            $category_id = $_GET['edit'];

            $query = "SELECT * FROM categories WHERE category_id = $category_id";
            $select_category_id = mysqli_query($connection, $query);

            //fetching the category
            while($row = mysqli_fetch_assoc($select_category_id)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
                ?>
                <!--displaying category in form field-->
                <input value="<?php if (isset($category_title)){echo $category_title;} ?>" type="text" class="form-control" name="category_title">
                <?php
            }
        }
        ?>

        <!--updating category-->
        <?php
        if (isset($_POST['update'])){
            $category_title_update = $_POST['category_title'];
            $query = "UPDATE categories SET category_title = '{$category_title_update}' WHERE category_id = '{$category_id}'";
            $update_categories = mysqli_query($connection, $query);
            if (!$update_categories){
                die("Query failed" . mysqli_error($connection));
            }
        }

        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Update Category" name="update">
    </div>

</form>
