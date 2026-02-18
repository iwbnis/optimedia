<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('user_model', 'user');
		$this->load->model('Product_model');
		___construct(1);
	}
	public function term_condition()
	{
		$data['page'] 	= $this->Product_model->getSettings('tnc');
		$this->load->view('term-condition', $data);
	}

	public function api_document()
	{

		$this->load->model('PagebuilderModel');
		$register_form = $this->PagebuilderModel->getSettings('registration_builder');

		$data['registration_fields'] = json_decode($register_form['registration_builder'],1);

		// $this->load->view('api_document');
		$this->load->view('document/document_header');
		$this->load->view('document/document_sidebar');
		$this->load->view('document/api_document', $data);
		$this->load->view('document/document_footer');
	}
}