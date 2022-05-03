<?php include "includes/header.php"; ?>

<?php
// check Form submission
if (isset($_POST['submit'])) {

    if (!empty($_POST['subject']) && !empty($_POST['email']) && !empty($_POST['body'])) {


        // email destination
        $to = "hreza389@gmail.com";

        //$name = $_POST['name']; // optional

        $subject = $_POST['subject'];
        $subject = wordwrap($subject, 70);

        $sender_email = $_POST['email'];

        $body = $_POST['body'];
        $body = wordwrap($body, 70); // use wordwrap() if lines are longer than 70 characters

        // check if the email is valid
        if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
        } else {
            $headers = "From: " . $sender_email;
            $result = mail($to, $subject, $body, $headers);
            if ($result) {
                $message = "Email sent successfully";
            } else {
                $message = "Email sending failed";
            }
        }

//        $subject = mysqli_real_escape_string($connection, $subject);
//        $email = mysqli_real_escape_string($connection, $email);
//        $body = mysqli_real_escape_string($connection, $body);
//        $message = "Your registration has been submitted.".'<br><br>'.'<a style="color: white" href="index.php">Login</a>';
    } else {
        $message = "Fields cannot be empty!";
    }
}
?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>

                        <form role="form" action="" method="post" id="contact-form">

                            <h6 style="background-color: dodgerblue;padding: 5px;color: white;" class="text-center">
                                <?php if (isset($message)) {
                                    echo $message;
                                } ?>
                            </h6>

                            <!--                            <div class="form-group">-->
                            <!--                                <label for="name" class="sr-only">name</label>-->
                            <!--                                <input autocomplete="off" type="text" name="name" id="name" class="form-control" placeholder="Name">-->
                            <!--                            </div>-->

                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input autocomplete="off" type="text" name="subject" id="subject" class="form-control"
                                       placeholder="Subject">
                            </div>

                            <div class="form-group">
                                <label for="" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            </div>

                            <div class="form-group">
                                <label for="body" class="sr-only"></label>
                                <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                            </div>

                            <input style="background-color: dodgerblue;color: white;" type="submit" name="submit"
                                   id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

    <hr>

    <?php include "includes/footer.php"; ?>
