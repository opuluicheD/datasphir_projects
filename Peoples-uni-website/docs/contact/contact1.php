<?php

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

     // "rfheller4@gmail.com"
    $mailTo = "rfheller4@gmail.com";
    $headers = "From: ".$mailFrom;
    $txt = "You have received an e-mail from ".$name.".\n\n".$message;

   mail($mailTo, $subject, $txt, $headers);
     // Redirect
    header("Location:success.html");
  } else {
    echo "No information found \n";
 }

?>
