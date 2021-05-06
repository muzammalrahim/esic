<?php
class Esicdetails extends MY_Controller{
    public function __construct(){
        parent::__construct();

    }
    public function index($uriSegment = NULL){
       
    }
    public function getdetails($alias){
		
      	$alias = str_replace('_',' ',$alias);
        $alias = str_replace('+','_',$alias);

        $esicData = $this->Esic_model->getDetails($alias);
       // $userID = $esicData['userID'];
        $listingID = $esicData['listingID'];
        $this->data['esic'] = $this->Esic_model->getDetails($alias);
        //echo '<pre>';
        //print_r($this->data['list']);
       // exit;
		$this->data['social'] = $this->Esic_model->getSocialDetail($listingID);
		$this->load->view('structure/header', $this->data);
        $this->load->view('product_details',$this->data);
		$this->load->view('structure/footer');
    }
}