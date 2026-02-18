<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/Format.php';

class My_Wallet extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->model('Common');
        $this->load->model('Product_model');
        $this->load->model('Total_model');
        $this->load->library('user_agent');
        $this->load->model("Form_model");
        $this->load->model('IntegrationModel');
    }

    public function my_wallet_post()
    {
        $headers = $this->input->request_headers();
        $verify_data = verify_request();
        if(isset($verify_data['status']) && $verify_data['status'] == 401) {
            $response = array(
                'status' => 401,
                'message' => 'Unauthorized Access!',
            );

            $this->response($response, 401); 
        }
        else
        {

            $this->form_validation->set_rules('page_id', 'page_id', 'required|trim',
            array('required'      => 'Oops ! page id is required.'
            ));

            $this->form_validation->set_rules('per_page', 'per_page', 'required|trim',
            array('required'      => 'Oops ! per page count is required.'
            ));

            $this->form_validation->set_error_delimiters('', '');
            if($this->form_validation->run()== false)
            {
                if(!empty(form_error('page_id')))$errors['page_id'] =form_error('page_id');
                if(!empty(form_error('per_page')))$errors['per_page'] =form_error('per_page');

                $response['message'] = "Please required field";
                $response['errors'] = $errors;

                $this->response($response, 422);
            }
            else
            {   
                $id = $verify_data['userdata']['id'];
                $type = $this->input->post('type');
                $paid_status = $this->input->post('paid_status');
                $page_id = $this->input->post('page_id');
                $per_page = $this->input->post('per_page');

                $filter = array(
                    'user_id' => $id,
                    'status_gt' => 0,
                    'parent_id' => 0,
                );

                if ( isset($type) && !empty($type) ) {
                    $filter['types'] = $type;
                }

                if (isset($paid_status) && !empty($paid_status)) {
                    $filter['paid_status'] = $paid_status;
                }

                $data['user_totals'] = $this->Total_model->getUserTotals((int)$id);

                $data['wallet_unpaid_amount'] = (float)$this->db->query("SELECT SUM(amount) as total FROM wallet WHERE status=1 AND user_id=". (int)$id)->row()->total;


                $filter['page_num'] = $page_id;        
                $filter['per_page'] = $per_page;        
                $filter['offset'] = ($filter['page_num'] - 1) * $per_page;

                $total_rows = $this->Wallet_model->getTransaction($filter, true);
                $data['transaction'] = $this->Wallet_model->getTransaction($filter);
                $response = array(
                    'status' => TRUE,
                    'message' => 'my wallet list get successfully',
                    'data' => $data
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }

 
}
?>