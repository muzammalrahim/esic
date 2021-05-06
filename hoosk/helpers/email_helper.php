<?php
if(!function_exists('getEmailConfig')) {
    function getEmailConfig()
    {
        $config = array();
        $config['useragent'] = USERAGENT;
        $config['protocol']  = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailtype']  = MAILTYPE;
        $config['charset']   = CHARSET;
        $config['newline']   = NEWLINE;
        $config['wordwrap']  = WORDWRAP;
        $config['isLive']    = ISLIVE;
        if(!empty(SMTP_PASSWORD)){
            $config['smtp_user']    = SMTP_USERNAME;
            $config['smtp_pass']    = SMTP_PASSWORD;
        }
        return $config;
    }
}
if(!function_exists('sendEmail')) {
    function sendEmail($ci,$subject,$to,$message)
    {
        $ci->load->library('email');
        $settings   = $ci->Hoosk_model->getSettings();
        $siteEmail  = $settings[0]['siteEmail'];
        $config     = getEmailConfig();
        if($config['isLive'] == TRUE && $_SERVER['HTTP_HOST'] != 'localhost'){
            $ci->email->initialize($config);
            $ci->email->from($siteEmail, 'From: Esic Directory');
            $ci->email->to($to);
            $ci->email->subject($subject);
            $ci->email->message($message);
            if($ci->email->send()){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }
}
if(!function_exists('newUserEmail')) {
    function newUserEmail($ci,$firstName, $email, $password){

        $subject = "Welcome To Esic Directory";
        $message = "Hi, ".$firstName." <br> Welcome To Esic Directory " . "    <br> Please Login To Activate Your Account <br>";
        $message .= "<a href='".BASE_URL."/login'>Click Here To Login</a><br>";
        $message .= "Your User Name: "."           ". $email ."<br>";
        $message .= "Your Password: "."            ". $password;
        sendEmail($ci,$subject,$email,$message);
        return true;
    }
}
if(!function_exists('customEmail')) {
    function customEmail($ci, $subject, $email, $message){
        $subjectGlobal = 'Esic Directory:';
        $subjectToSent = $subjectGlobal.' '.$subject;
        sendEmail($ci, $subjectToSent, $email, $message);
        return null;
    }
}
