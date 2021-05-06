<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron_Update_Status extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    public function SavePreviousStatus(){

        $response = Admincontrol_helper::SavePreviousStatus($this);
        if ($response){
            echo 'OK::Status Successfully Reset::success::Success';
        }
        else
            echo 'OK::Not Reset. Try again::error::Error';
    }
}