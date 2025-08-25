<?php
include "header.php";

if(isset($_POST['submit']))
{  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    
    $message = "<strong>Dear $name,</strong><br />
                <strong>Your Email ID is :</strong> $email<br />
                <strong>Message :-</strong> $comment
                ";
    
    // Send email
    sendMail("yashikachinz1997@gmail.com", "Mail from Appoint My Doctor", $message);
}

?>

<div class="wrapper col2">
    <div id="breadcrumb">
        <ul>
            <li class="first">Contact Us</li>
        </ul>
    </div>
</div>

<div class="wrapper col4">
    <div id="container">
        <h6>Our Address</h6>
        <p>Online Hospital Management System, Bangalore<br />
            <strong>tel</strong>: 080 65110488<br />
            <strong>Email ID</strong>: ohms@gmail.com</p>

        <h6>Contact Us by entering the following information</h6>
        <form action="" method="post">
            <p>
                <input type="text" name="name" id="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" size="22" />
                <label for="name"><small>Name (required)</small></label>
            </p>
            <p>
                <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" size="22" />
                <label for="email"><small>Email (required)</small></label>
            </p>
            <p>
                <textarea name="comment" id="comment" cols="100%" rows="10"><?php echo isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : ''; ?></textarea>
                <label for="comment" style="display:none;"><small>Comment (required)</small></label>
            </p>
            <p>
                <input name="submit" type="submit" id="submit" value="Submit Form"  />
                &nbsp;
                <input name="reset" type="reset" id="reset" tabindex="5" value="Reset Form" />
            </p>
        </form>
    </div>
</div>

<div class="clear"></div>
</div>
</div>

<?php
include "footer.php";

function sendMail($toAddress, $subject, $message)
{
    require 'PHPMailer-master/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'mail.dentaldiary.in';
    $mail->SMTPAuth = true;
    $mail->Username = 'sendmail@dentaldiary.in';
    $mail->Password = 'q1w2e3r4/';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->From = 'sendmail@dentaldiary.in';
    $mail->FromName = 'Web Mall';
    $mail->addAddress($toAddress, 'Joe User');
    $mail->addReplyTo('aravinda@technopulse.in', 'Information');
    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $message;

    if(!$mail->send()) {
        echo '<center><strong><font color="red">Message could not be sent.</font></strong></center>';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<center><strong><font color="green">Mail sent.</font></strong></center>';
    }
}
?>
