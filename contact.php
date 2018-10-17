<?php

include_once('config/sqlconnect.php');

if(isset($_POST['submit'])) {

   $prenom = htmlspecialchars(ucfirst(strtolower($_POST['firstname'])));
   $nom = htmlspecialchars(ucfirst(strtolower($_POST['lastname'])));
   $email = htmlspecialchars($_POST['email']);
   $message = htmlspecialchars($_POST['message']);
   $emailTo = "contact@ynkrabo.fr";
   $checkbox = $_POST['checkbox'];

   $_SESSION['firstname'] = $prenom;
   $_SESSION['lastname'] = $nom;
   $_SESSION['email'] = $email;

   if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && isset($_POST['message'])) {

      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

         $header = "MIME-Version: 1.0\r\n";
         $header .= 'From: "Ynkrabo.fr" <contact@ynkrabo.fr>'."\n";
         $header .= 'Content-Type:text/html; charset="utf-8"'."\n";
         $header .= 'Content-Transfer-Encoding: 8bit';

         $body = '
         <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
               <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
               <title>Contact</title>
               <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            </head>
            <body style="margin: 0; padding: 0;">
               <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                  <tr>
                     <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0;">
                        <img src="https://blog.ynkrabo.fr/img/logo.png" alt="Creating Email Magic" width="230" height="230" style="display: block;" />
                     </td>
                  </tr>
                  <tr>
                     <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                              <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; font-variant: small-caps;">
                                 Thank you for sending me a message!
                              </td>
                           </tr>
                           <tr>
                              <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                 '.$message.'
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr >
                     <td align="right" bgcolor="#ee4c50" style="padding: 10px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                              <td width="100%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px; text-align:center;">
                                  &reg; Ynkrabo 2017-'.date('Y').'<br/>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </body>
         </html>
         ';

         if (empty($checkbox)) {
            mail($emailTo, 'Blog message from '.$nom.' '.$prenom, $body, $header);
         } else {
            mail($emailTo.', '.$email, 'Blog message from '.$nom.' '.$prenom, $body, $header);
         }

         $success = "Your message has succesfully been sent !";
         unset($_SESSION);
      } else {
         $erreur = "Your email is not valid !";
      }
   } else {
      $erreur = "Fill out all fields !";
   }
}

$pagetitle = 'Blog - Contact';

include('tpl/header.phtml');
include('tpl/contact.phtml');
include('tpl/footer.phtml');