<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hoosk_default extends MY_Controller {

	function __construct(){
		parent::__construct();
	}
	public function index(){
    $totSegments = $this->uri->total_segments();
    if(!is_numeric($this->uri->segment($totSegments))){
        $pageURL = $this->uri->segment($totSegments);
    } else if(is_numeric($this->uri->segment($totSegments))){
        $pageURL = $this->uri->segment($totSegments-1);
    }
    $array = array();
    $array = array("criteria.html","resources.html","innovators1.html","home.html","index.html");
    if(in_array($pageURL,$array)=== TRUE ){
        header('Location:'.BASE_URL);
    }
    if ($pageURL == ""){ $pageURL = "home"; }
    $pageData = $this->Hoosk_page_model->getPage($pageURL);
    //Replace the Short Codes with their defined values in the database.
    $this->data['page'] = render_slider($pageData);
    if ($this->data['page']['pageTemplate'] != ""){
        $this->data['header'] = $this->load->view('structure/header', $this->data, true);
        $this->data['footer'] = $this->load->view('structure/footer', '', true);
        $this->load->view('templates/'.$this->data['page']['pageTemplate'], $this->data);
    } else {
        $this->error();
    }}
    public function old_urls(){
	    echo base_url();
	    exit;
	 }
		public function category()
	{
		$catSlug = $this->uri->segment(2);
		$this->data['page']=$this->Hoosk_page_model->getCategory($catSlug);
		if ($this->data['page']['categoryID'] != ""){
		$this->data['header'] = $this->load->view('structure/header', $this->data, true);
		$this->data['footer'] = $this->load->view('structure/footer', '', true);
		$this->load->view('templates/category', $this->data);
		} else {
			$this->error();
		}
	}

		public function article()
	{
		$articleURL = $this->uri->segment(2);
		$this->data['page']=$this->Hoosk_page_model->getArticle($articleURL);
		if ($this->data['page']['postID'] != ""){
		$this->data['header'] = $this->load->view('structure/header', $this->data, true);
		$this->data['footer'] = $this->load->view('structure/footer', '', true);
		$this->load->view('templates/article', $this->data);
		} else {
			$this->error();
		}
	}

	public function error()
	{
		$this->data['page']['pageTitle']="Oops, Error";
		$this->data['page']['pageDescription']="Oops, Error";
		$this->data['page']['pageKeywords']="Oops, Error";
		$this->data['page']['pageID']="0";
		$this->data['header'] = $this->load->view('structure/header', $this->data, true);
		$this->data['footer'] = $this->load->view('structure/footer', '', true);
		$this->load->view('templates/error', $this->data);
	}
}

