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
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>

                    <!--
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Blank Page
                        </li>
                    </ol>
                    -->

                </div>
            </div>
            <!-- /.row -->


            <!-- widget -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <a style="color: white" href="posts.php"><i class="fa fa-file-text fa-5x"></i></a>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php

                                        $post_count = recordCount('posts');
                                        echo "<a style='color: white;text-decoration: none' href='posts.php' class='huge'>$post_count</a>";
                                    ?>
                                    <div><a style="color: white;text-decoration: none" href="posts.php">Posts</a></div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <a style="color: white" href="comments.php"><i class="fa fa-comments fa-5x"></i></a>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                        $comment_count = recordCount('comments');
                                        echo "<a style='color: white;text-decoration: none' href='comments.php' class='huge'>$comment_count</a>";
                                    ?>
                                    <div><a style="color: white;text-decoration: none" href="comments.php">Comments</a></div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <a style="color: white" href="users.php"><i class="fa fa-user fa-5x"></i></a>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                        $user_count = recordCount('users');
                                        echo "<a style='color: white;text-decoration: none' href='users.php' class='huge'>$user_count</a>";
                                    ?>
                                    <div><a style="color: white;text-decoration: none" href="users.php">Users</a></div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">

                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <a style="color: white" href="categories.php"><i class="fa fa-list fa-5x"></i></a>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                        $category_count = recordCount('categories');
                                        echo "<a style='color: white;text-decoration: none' href='categories.php' class='huge'>$category_count</a>";
                                    ?>
                                    <div><a style="color: white;text-decoration: none" href="categories.php">Categories</a></div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- /widget -->

<?php
// count posts with status draft
$post_draft_count = checkStatus('posts', 'post_status', 'draft');

// count posts with status published
$post_published_count = checkStatus('posts', 'post_status', 'published');

// count unapproved comments
$unapproved_comment_count = checkStatus('comments', 'comment_status', 'unapproved');

// count subscriber users
$subscriber_count = checkStatus('users', 'user_role', 'subscriber');
?>
            <!-- google chart -->
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],

                            <?php
                            $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
                            $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $unapproved_comment_count, $user_count, $subscriber_count, $category_count];

                            // get array length
                            $element_text_length = count($element_text);
                            for ($i = 0; $i < $element_text_length; $i++) {
                                echo "['{$element_text[$i]}', {$element_count[$i]}],";
                            }
                            ?>


                        ]);

                        var options = {
                            chart: {
                                title: 'Title',
                                subtitle: 'Subtitle',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                <div id="columnchart_material" style="width: auto; height: 500px;"></div>
            </div>
            <!-- end google chart -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>
