<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/vendor/phpmailer/phpmailer/src/Exception.php';

require 'mailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';

require 'mailer/vendor/phpmailer/phpmailer/src/SMTP.php';


if ($_POST) {
  $saved = false;
  
  $emailTo = $_POST["emailTo"];
  $headers = "From: ".$_POST["emailFrom"];
  $subject = $_POST["subject"];
  $body = $_POST["body"];
  
  $email = new PHPMailer(TRUE);
  $email->From      = $_POST["emailFrom"];
  $email->FromName  = substr($_POST["emailFrom"], 0, strpos($_POST["emailFrom"], "@"));
  $email->Subject   = $_POST["subject"];
  $email->Body      = $_POST["body"];
  $email->AddAddress($_POST["emailTo"]);

  if(file_exists($_FILES['doc']['tmp_name'])) {
    $uploaddir = "uploads/";
    $uploadfile = $uploaddir . basename($_FILES["doc"]["name"]);
    move_uploaded_file($_FILES['doc']['tmp_name'], $uploadfile);
    $email->AddAttachment( $uploadfile, $_FILES["doc"]["name"]);
    $saved = true;
  }


  if($email->Send()) {
    echo "<div class='alert alert-success alert-dismissible fade show' id='successTip' role='alert'><strong>The email was sent!</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
  } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' id='failTip' role='alert'><strong>The email wasn't sent</strong> Try again.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
  }
  
  if ($saved) {
    unlink($uploadfile); 
  } 
   
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <title>Mail to Anyone</title>
  </head>
  <body>
    <div class="container">
      <h1 class="display-4 text-center">Send an email:</h1>
      
<!--
      <div class="alert alert-success alert-dismissible fade d-none" id="failTip" role="alert">
        <strong>The email was sent! </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
-->
      
      <div class="alert alert-danger alert-dismissible fade d-none" id="failTip" role="alert">
        <strong>Fill in all the required fields. </strong>The try again.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="emailTo">To: </label>
          <input type="email" class="form-control" id="emailTo" name="emailTo" aria-describedby="emailHelp" placeholder="Email" required>
        </div>
        <div class="form-group">
          <label for="emailTo">From: </label>
          <input type="email" class="form-control" id="emailFrom" name="emailFrom" aria-describedby="emailHelp" placeholder="Email" required>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="subject">Subject: </label>
          <input type="text" class="form-control" id="subject" name="subject" aria-describedby="emailHelp" placeholder="of your email" required>
        </div>
        <div class="form-group">
          <label for="body">Text: </label>
          <textarea type="text" rows="8" class="form-control " id="body" name="body" aria-describedby="emailHelp" placeholder="of your email" required></textarea>
        </div>
        <div class="form-group">
          <label for="doc">Attachment:</label>
          <input type="file" class="form-control-file" id="doc" name="doc">
        </div>

        <button type="submit" id="send-btn" class="btn-lg btn-primary">Send</button>
      </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    

  </body>
</html>

