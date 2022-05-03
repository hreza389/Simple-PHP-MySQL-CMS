<?php
include "includes/header.php";

checkIfUserIsLoggedInAndRedirect('admin/index.php');

// check request method (post/get)
if (ifItIsMethod('post')) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        login_user($username, $password);
    }
    else {
        redirect('login.php');
    }
}


?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">


                                <form id="login-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

                                            <input name="username" type="text" class="form-control" placeholder="Enter Username">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                                    </div>


                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->






<!--// if login form submit button is clicked-->

<!--//if (isset($_POST['login'])) {-->
<!--//    login_user($_POST['username'], $_POST['password']);-->
<!--//}-->
<!--//else {-->
<!--//    header("Location: ../index.php");-->
<!--//}-->
