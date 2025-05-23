<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class ControladorCorreo
{
    static public function ctrEnviarCorreo()
    {
        if(isset($_POST["nombreContacto"]))
        {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreContacto"]) &&
                filter_var($_POST["emailContacto"], FILTER_VALIDATE_EMAIL) &&
                preg_match('/^[-\\$\\,\\.\\#\\"\\!\\¿\\?\\¡\\*\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["mensajeContacto"])
            )
            {
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try 
                {
                    //Server settings
                    /* $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'user@example.com';                     //SMTP username
                    $mail->Password   = 'secret';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                */
                    $mail->isMail(); // or $mail->isSendmail();
                    //Recipients
                    
                    $mail->setFrom($_POST["emailContacto"], $_POST["nombreContacto"]);
                    $mail->addAddress('octaviohaurigot@gmail.com', 'Octavio');     //Add a recipient
                    
                    //$mail->addAddress('ellen@example.com');               //Name is optional
                    
                    $mail->addReplyTo($_POST["emailContacto"], $_POST["nombreContacto"]);
                    
                    //$mail->addCC('cc@example.com');
                    //$mail->addBCC('bcc@example.com');
                
                    //Attachments
                    /* $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                */
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Mensaje del blog';
                    $mail->Body    = '<div>'.$_POST["mensajeContacto"].'</div>';
                    $mail->AltBody = $_POST["mensajeContacto"];
                
                    $mail->send();
                    return "Ok";
                } 
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            else
            {
                return "error-sintaxis";
            }
        }
    }
}