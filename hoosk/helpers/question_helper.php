<?php


/**
 * @function checkAdminRole2 
 */
if(!function_exists('checkAdminRole2')){
    function checkAdminRole2($ci){
        Admincontrol_helper::is_logged_in($ci->session->userdata('userID'));
        $userRole = $ci->session->userdata('userRole');
        //We Don't want un authorized access
        if($userRole != 1){
            $ci->load->view('admin/page_not_found');
            return false;
        }
        return true;
    }
}

?>
