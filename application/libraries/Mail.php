<?php defined('BASEPATH') OR exit('No direct script access allowed');
include('sparkpostphpcurl-master/sparkpost-api.php');
class Mail {

    function sendMail($to,$message,$subject){
        $url = SP_URL;
        $key = SP_KEY;
        $mail = new sparkPostApi($url,$key);
        $mail-> from(array('email' => SP_EMAIL,'name' => SP_NAME));
        $mail-> subject($subject);
        $mail-> html($message);
        $mail-> setTo(array($to));
        $mail->setReplyTo(SP_EMAIL);
        $res = $mail->send();
        $mail->close();
    }

    function send_sparkpost_attach($body, $toemail, $subject, $pdfFilePath='', $pdf_name=''){
        $mail = new sparkPostApi(SP_URL,SP_KEY);        
        $mail-> from(array('email' => SP_EMAIL,'name' => SP_NAME));
        $mail-> subject($subject);
        $mail-> html($body);
        $mail-> setTo($toemail);
        $mail->setReplyTo(SP_EMAIL);
        if($pdfFilePath != ""){
            //echo $pdfFilePath;exit;
            $filePath = $pdfFilePath;
            $fileName = $pdf_name;
            //echo $filePath.$fileName;exit;
            $fileType = mime_content_type($filePath);
            $fileData = base64_encode(file_get_contents($filePath));
            $arr = array();
            $arr[] = array('name' => $fileName, 'type' => $fileType, 'data' => $fileData);
            $mail->attachments($arr);
        }
        
        try{
            $res = $mail->send();
            //print_r($res);
            //print "arraytextMessage Sent";
        }catch (Exception $e) {
           //print $e;
        }        
        $mail->close();
        //return $res;
    }

}