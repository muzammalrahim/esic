<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Admincontrol_helper
 {
     static function is_logged_in($userName)
     {
         if (($userName == "")):
             $redirect = BASE_URL . '/login';
             header("Location: $redirect");
             exit;
         endif;
     }
     static function SavePreviousStatus($ci)
     {
         $counter = 1;
         while($counter < 5) {
             switch ($counter) {
                 case 1:
                     $ci->tableName   = 'esic';
                     $ci->statusField = 'status';
                     break;
                 case 2:
                     $ci->tableName   = 'esic_accelerators';
                     $ci->statusField = 'AppStatus';
                     break;
                 case 3:
                     $ci->tableName   = 'esic_lawyers';
                     $ci->statusField = 'Publish';
                     break;
                 case 4:
                     $ci->tableName   = 'esic_grantconsultant';
                     $ci->statusField = 'Publish';
                     break;
                 default:
                     break;
             }
             $currentYear = date('Y');
             //$where = array('date_updated <' => $currentYear .'-07-01');
             $where  = array('date_updated <' => $currentYear . '-07-01');
             $result = $ci->Common_model->select_fields_where($ci->tableName, 'COUNT(id) as Total', $where, true);
             if ($result->Total > 0) {
                 $selectData = 'id AS listing_id, ' . $ci->statusField . ' AS prev_status, date_updated AS status_date';
                 $result = $ci->Common_model->select_fields($ci->tableName, $selectData, '', '', '', true);
                 if ($ci->tableName == 'esic')
                     $listing_type = 1;
                 else if ($ci->tableName == 'esic_accelerators')
                     $listing_type = 3;
                 else if ($ci->tableName == 'esic_lawyers')
                     $listing_type = 7;
                 else if ($ci->tableName == 'esic_grantconsultant')
                     $listing_type = 8;
                 if ((is_array($result) || is_object($result)) && (!empty($result))) {
                     foreach ($result as $key => $row) {
                         $result[$key]['listing_type'] = $listing_type;
                     }
                 }
                 $ci->db->insert_batch('listing_status', $result);
                 // set original status to pending
                 $updateData = array('date_updated' => date('Y-m-d h:m:s'));
                 if ($ci->tableName == 'esic_lawyers' || $ci->tableName == 'esic_grantconsultant'){
                     $updateData[$ci->statusField] = 0;
                 }else if($ci->tableName == 'esic'){
                     $updateData[$ci->statusField] = 30;
                 }
                 else{
                     $updateData[$ci->statusField] = 1;
                 }
                 $response = $ci->db->update($ci->tableName, $updateData);
             }// end of function
             $counter++;
             $ci->tableName   = "";
             $ci->statusField = "";
         }
         return $response;

     }

}
// static function SavePreviousStatus($ci) old
//     {
//         $counter = 1;
//         while($counter < 5) {
//
//             switch ($counter) {
//                 case 1:
//                     $ci->tableName   = 'esic';
//                     $ci->statusField = 'status';
//                     break;
//                 case 2:
//                     $ci->tableName   = 'esic_accelerators';
//                     $ci->statusField = 'AppStatus';
//                     break;
//                 case 3:
//                     $ci->tableName   = 'esic_lawyers';
//                     $ci->statusField = 'Publish';
//                     break;
//                 case 4:
//                     $ci->tableName   = 'esic_grantconsultant';
//                     $ci->statusField = 'Publish';
//                     break;
//                 default:
//                     break;
//             }
//
//             $currentYear = date('Y');
//             //$where = array('date_updated <' => $currentYear .'-07-01');
//             $where = array('date_updated <' => $currentYear . '-07-01');
//
//             $result = $ci->Common_model->select_fields_where($ci->tableName, 'COUNT(id) as Total', $where, true);
//             if ($result->Total > 0) {
//                 $selectData = 'id AS listing_id, ' . $ci->statusField . ' AS prev_status, date_updated AS status_date';
//                 $result = $ci->Common_model->select_fields($ci->tableName, $selectData, '', '', '', true);
//                 if ($ci->tableName == 'esic')
//                     $listing_type = 1;
//                 else if ($ci->tableName == 'esic_accelerators')
//                     $listing_type = 3;
//                 else if ($ci->tableName == 'esic_lawyers')
//                     $listing_type = 7;
//                 else if ($ci->tableName == 'esic_grantconsultant')
//                     $listing_type = 8;
//                 if ((is_array($result) || is_object($result)) && (!empty($result))) {
//                     foreach ($result as $key => $row) {
//                         $result[$key]['listing_type'] = $listing_type;
//                     }
//                 }
//                 $ci->db->insert_batch('listing_status', $result);
//                 // set original status to pending
//                 $updateData = array('date_updated' => date('Y-m-d h:m:s'));
//                 if ($ci->tableName == 'esic_lawyers' || $ci->tableName == 'esic_grantconsultant')
//                     $updateData[$ci->statusField] = 0;
//                 else
//                     $updateData[$ci->statusField] = 1;
//                 $response = $ci->db->update($ci->tableName, $updateData);
//                // return $response;
//
//             }// end of function
//
//             $counter++;
//             $ci->tableName   = "";
//             $ci->statusField = "";
//
//         }
//         return $response;
//
//     }
//
// }
     // when new year'll come, save previous listing status to listing_status table, and set status to pending in original listing table
//     static function SavePreviousStatus($ci)
//     {
//
//         $selectData = 'id AS listing_id, status AS prev_status, date_updated AS status_date';
//         $result = $ci->Common_model->select_fields('esic', $selectData, '', '', '', true);
//         $listing_type = 1;
//         if ((is_array($result) || is_object($result)) && (!empty($result))) {
//             foreach ($result as $key => $row) {
//                 $result[$key]['listing_type'] = $listing_type;
//             }
//         }
//         $selectData = 'status_date';
//         $results = $ci->Common_model->select_fields('listing_status', $selectData, '', '', '', true);
//         if($results['0']['status_date'] == date ('Y')){
//
//         }
//         $response = $ci->db->insert_batch('listing_status', $result);
//         return $response;
//     }
// }

