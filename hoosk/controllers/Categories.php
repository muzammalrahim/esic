<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('file');
	}

	public function index()
	{
		Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
		$this->load->library('pagination');
    $result_per_page =15;  // the number of result per page
    $config['base_url'] = BASE_URL. '/admin/posts/categories/';
    $config['total_rows'] = $this->Hoosk_model->countCategories();
		$config['uri_segment'] = 4;
    $config['per_page'] = $result_per_page;
		$config['full_tag_open'] = '<div class="form-actions">';
		$config['full_tag_close'] = '</div>';
    $this->pagination->initialize($config);
		//Get categorys from database
		$this->data['categories'] = $this->Hoosk_model->getCategoriesAll($result_per_page, $this->uri->segment(4));
		//Load the view
		$this->data['header'] = $this->load->view('admin/header', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/post_categories', $this->data);
	}

	public function addCategory()
	{
		Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
		//Load the form helper
		$this->load->helper('form');
		//Load the view
		$this->data['header'] = $this->load->view('admin/header', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/post_category_new', $this->data);
	}

	public function confirm()
	{
		Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
		//Load the form validation library
		$this->load->library('form_validation');
		//Set validation rules
		$this->form_validation->set_rules('categorySlug', 'category slug', 'trim|alpha_dash|required|is_unique[hoosk_post_category.categorySlug]');
		$this->form_validation->set_rules('categoryTitle', 'category title', 'trim|required');

		if($this->form_validation->run() == FALSE) {
			//Validation failed
			$this->addCategory();
		}  else  {
			//Validation passed
			//Add the category
			$this->Hoosk_model->createCategory();
			//Return to category list
			redirect('/admin/posts/categories', 'refresh');
	  	}
	}

	public function editCategory()
	{
		Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
		//Load the form helper
		$this->load->helper('form');
		//Get category details from database
		$this->data['category'] = $this->Hoosk_model->getCategory($this->uri->segment(5));
		//Load the view
		$this->data['header'] = $this->load->view('admin/header', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/post_category_edit', $this->data);
	}

	public function edited()
	{
		Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
		//Load the form validation library
		$this->load->library('form_validation');
		//Set validation rules
		$this->form_validation->set_rules('categorySlug', 'category slug', 'trim|alpha_dash|required|is_unique[hoosk_post_category.categorySlug.categoryID.'.$this->uri->segment(5).']');
		$this->form_validation->set_rules('categoryTitle', 'category title', 'trim|required');

		if($this->form_validation->run() == FALSE) {
			//Validation failed
			$this->editCategory();
		}  else  {
			//Validation passed
			//Update the category
			$this->Hoosk_model->updateCategory($this->uri->segment(5));
			//Return to category list
			redirect('/admin/posts/categories', 'refresh');
	  	}
	}




	function delete()
	{
		Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
		if($this->input->post('deleteid')):
			$this->Hoosk_model->removeCategory($this->input->post('deleteid'));
			redirect('/admin/posts/categories');
		else:
			$this->data['form']=$this->Hoosk_model->getCategory($this->uri->segment(5));
			$this->load->view('admin/post_category_delete.php', $this->data );
		endif;
	}

}
