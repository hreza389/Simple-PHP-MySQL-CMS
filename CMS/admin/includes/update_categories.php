<!--                        update form -->
<form action="" method="post">
    <div class="form-group">

        <?php
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];


            $query = "select * from categories where cat_id = {$cat_id}";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>
                <label for="cat-title">Update Category</label>
                <input style="margin-bottom: 15px" value="<?php if (isset($cat_title)) {
                    echo $cat_title;
                } ?>" type="text" class="form-control" name="cat_title">
                <input type="submit" class="btn btn-primary" name="update_category" value="Update Category">

            <?php }
        }

        // Update the category
        if (isset($_POST['update_category'])) {

            $cat_title = $_POST['cat_title'];

            $stmt = mysqli_prepare($connection, "update categories set cat_title = ? where cat_id = ?");
            mysqli_stmt_bind_param($stmt, 'si', $cat_title, $cat_id);
            mysqli_stmt_execute($stmt);
            if (!$stmt) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
            mysqli_stmt_close($stmt);
            // redirect
            header("Location: categories.php");
        }
        ?>

    </div>
</form>