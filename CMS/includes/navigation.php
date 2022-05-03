<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <!-- Mobile - Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php">Home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">


                <?php
                // select all categories from the database
                $query = "SELECT * FROM categories limit 3";
                $select_all_categories_query = mysqli_query($connection, $query);

                $category_class = '';
                $registration_class = '';
                $contact_class = '';
                // get the current file name
                $file_name = basename($_SERVER['PHP_SELF']);


                // echo out the categories as links
                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

//                    if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
//                        $category_class = 'active';
//                    } else if ($file_name == 'registration.php') {
//                        $registration_class = 'active';
//                    } else if ($file_name == 'contact.php') {
//                        $contact_class = 'active';
//                    }

                    // echo all categories in the navbar
                    echo "<li class='$category_class'><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                }

                if (isLoggedIn()) {
                    echo "<li class='$contact_class'><a href='../CMS/admin/index.php'>Admin</a></li>";
                    echo "<li class='$contact_class'><a href='./admin/includes/logout.php'>Logout</a></li>";
                } else {
                    echo "<li class='$contact_class'><a href='login.php'>Login</a></li>";
                }
                ?>

                <li class="<?php echo $registration_class; ?>"><a href="./registration.php">Registration</a></li>
                <li class="<?php echo $contact_class; ?>"><a href="./contact.php">Contact</a></li>


                <?php
                // if the user is logged in and is watching the post page then show the post edit button
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                        echo "<li><a style='background-color: dodgerblue;color: white;border-radius: 10px;' href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                    }
                }
                ?>

                <!--                <li><a href="#">Services</a></li>-->
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

