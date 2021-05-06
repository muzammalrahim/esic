<?php
class User_model extends MY_Model{
    private $UserTable    = 'hoosk_user';
    private $tableCurrent = 'hoosk_user';
    function __construct(){
        parent::__construct();
    }
    private function UserIDWhere(){
        $where = $this->getUserWhere();
        $this->db->where($where);
    }
    public function count(){
        $where = $this->getUserWhere();
        return $this->Common_model->count_rows($this->tableCurrent,$where);
    }
    public function CreateNewUser($data){
        if($this->FieldAlreadyExist('UserName',$data['username']) == true){
            return 'FAIL::That Username Already Exist. If its your than please click below on login::Error::login'; // ::login to show login link
        }
        if($this->FieldAlreadyExist('email',$data['Email']) == true){
            return 'FAIL::That Email Already Exist. If its your than please click below on login::Error::login'; // ::login to show login link
        }
        if($this->Common_model->insert_record($this->UserTable, $data)){
            return  'Success::Your Account is created. Please Check Your Email.::Success';
        }else{
            return 'FAIL::Sorry There is an Error Please Contact Admin::Error';
        }
    }
    Private function FieldAlreadyExist($DB_Field, $User_Data)
    {
        $Where[$DB_Field] = $User_Data;
        if (!empty($this->db->get_where($this->UserTable, $Where)->result_array())){
            return true;
        }
        return false;
    }
}