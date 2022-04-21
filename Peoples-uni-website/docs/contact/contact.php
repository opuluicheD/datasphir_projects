<?php

$error_reporting(0);
$msg = '';

//$name = $_POST['name'];
//$email = $_POST['email'];
//$subject = $_POST['subject'];
//$message = $_POST['message'];

//$to = "iamdainelchukwuma@gmail.com";
//$headers = "From: ".$mailFrom;
//$txt = "You have received an e-mail from ".$name.".\n\n".$message;

//if ($email!=NULL){
//  mail($to, $headers, $subject, $txt);
//  header("Location:success.html");
//}  else {
//   echo "No information found";
//}


 if (isset($_POST['submit'])){
     $name = trim($_POST['name']);
     $mailFrom = trim($_POST['email']);
     $subject = trim($_POST['subject']);
     $message = trim($_POST['message']);

   //   $subject = "<strong>".$subject."</strong>"

     // "rfheller4@gmail.com"
    $mailTo = "iamdanielchukwuma@gmail.com";
    $subject = "<strong>.$subject.''. </strong>";
    $headers = "From: ".$mailFrom;
    $txt = "You have received an e-mail from ".$name.".\n\n".$message;


    $secretKey = "6LePAvoaAAAAAJAp3epxQYuzjdZghLbhowy9GeSU";
    $responseKey = $_POST["g-recaptcha-response"];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";

    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success){
       if (mail($mailTo, $subject, $txt, $headers)){
         // $msg = '<h4 class="succes">Mail sent successfully!</h4>';
          header("Location:success.html");
       }else {
          $msg = '<h4 class="failed">Failed to send mail!</h4>';
       }
    } else {
       $msg = '<h4 class="failed">Verification Failed!</h4>';
    }

   // mail($mailTo, $subject, $txt, $headers);
     // Redirect
   //  echo "Thank You!" . " -" . "<a href='./index.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
   //  header("Location:success.html");
  } else {
    echo "No information found \n";
 }

?>
