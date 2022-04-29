<?php //include "../includes/db.php" ?>
<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Hamid</small>
                    </h1>

                    <?php
                    $source = $_GET['source'] ?? ''; // this is a short hand
//                  if (isset($_GET['source'])) {$source = $_GET['source'];} else {$source = '';}

                    # include if ...
                    switch ($source) {

//                        case 'add_post':
//                            include "includes/add_post.php";
//                            break;
//
//                        case 'edit_post':
//                            include "includes/edit_post.php";
//                            break;

                        default:
                            include "includes/view_all_comments.php";
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
    <?php include "includes/admin_footer.php"; ?>
