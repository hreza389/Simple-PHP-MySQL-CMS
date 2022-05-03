<?php

// PHP MAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


include "includes/header.php";
include "Classes/Config.php";
require '../vendor/autoload.php';

// if forgot variable isn't set or is empty, then redirect.
if (empty($_GET['forgot'])) {
    redirect('index.php');
}

// FORM SUBMISSION
if (ifItIsMethod('post')) {

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if (email_exists($email)) {
            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='$token' WHERE user_email= ?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                /**
                    configure PHPMailer - Server settings
                **/

                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = Config::SMTP_HOST;
                $mail->Username = Config::SMTP_USER;
                $mail->Password = Config::SMTP_PASSWORD;
                $mail->Port = Config::SMTP_PORT;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('edwin@codingfaculty.com', 'Edwin Diaz');
                $mail->addAddress($email);

                $mail->Subject = 'This is a test email';

                $mail->Body = '<p>Please click to reset your password
                                    <a href="http://localhost:63342/CMC-Project/CMS/reset.php?email='.$email.'&token='.$token.'">Click Here To Reset</a>
                               </p>';

                if ($mail->send()) {
                    $emailSent = true;
                    $message = '<b>Email sent.</b>'.'<br>'.'<b>Please check your email.</b>'.'<br>'.anchor('index.php', 'Home');
                }
                else {
                    $message = 'Email not sent.'.$mail->ErrorInfo;
                }
            }
        }
        else {
            $message = 'Email does not exist in database.'.'<br>'.'<a href="registration.php"><b>Register</b></a>';
        }
    }
    else {
        $message = "Email Field cannot be empty.";
    }
}
?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <!-- show user messages -->
                            <?php if (!empty($message) && isset($message)) { ?>
                                <div class="alert alert-info">
                                    <?php echo $message; ?>
                                </div>
                            <?php } ?>

                            <?php if (!isset($emailSent)){ ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Your Password?</h2>
                                <p>You can reset your password here.</p>

                                <div class="panel-body">

                                    <form action="" id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <label for="email"></label>
                                                <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->

