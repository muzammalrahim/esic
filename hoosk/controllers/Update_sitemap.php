<?php

class Update_sitemap extends MY_Controller
{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $data['data'] = $this->Esic_model->get_site_data();
        $data['company'] = $this->Esic_model->select_esic_url('esic');
        $data['Lawyer'] = $this->Esic_model->get_lawyer_url();
        $data['RndConsultant'] = $this->Esic_model->get_RndConsultant_url();
        $data['GrantConsultant'] = $this->Esic_model->get_GrantConsultant_url();
        $data['Accelerator'] = $this->Esic_model->get_Accelerator_url();
        $data['blog'] = $this->Esic_model->get_blog_url();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap",$data);
   }
}