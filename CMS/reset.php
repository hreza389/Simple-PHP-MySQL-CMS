<?php include "includes/header.php";


// if 'email' and 'token' variables are not set or are empty in the URL , redirect
if (empty($_GET['email']) || empty($_GET['token'])) {
    header("Location: index.php");
}


if ($stmt = mysqli_prepare($connection, "SELECT user_username , user_email , token FROM users WHERE token = ?")) {
    mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// FORM Submission
if (isset($_POST['resetPassword'])) {

    if (empty($_POST['password']) || empty($_POST['confirmPassword'])) {
        $message = "Please fill in all fields.";
    }
    else {
        if ($_POST['password'] != $_POST['confirmPassword']) {
            $message = "Passwords do not match.";
        }
        else {
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

            if ($stmt = mysqli_prepare($connection, "UPDATE users SET user_password = ? WHERE user_email = ?")) {
                mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $_GET['email']);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) >= 1) {
                    header("Location: login.php");
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}

?>


<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>

                            <!-- show user messages -->
                            <?php if (!empty($message) && isset($message)) { ?>
                                <div class="alert alert-info">
                                    <?php echo $message; ?>
                                </div>
                            <?php } ?>

                            <div class="panel-body">

                                <form action="" id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <label for="password"></label>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control" type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <label for="confirmPassword"></label>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="confirm password" class="form-control" type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

<!--                                 <input type="hidden" class="hide" name="token" id="token" value="">-->
                                    <!-- <input type="hidden" class="hide" name="action" id="action" value="resetPassword">-->

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<?php include "includes/footer.php"; ?>


<!--    <script src="js/jquery.easing.min.js"></script>-->
<!--    <script src="js/jquery.fittext.js"></script>-->
<!--    <script src="js/wow.min.js"></script>-->
<!--    <script src="js/creative.js"></script>-->

