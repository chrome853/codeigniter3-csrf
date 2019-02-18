<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $data = array();

    public function __construct()
    {
        parent::__construct();

    }

    protected function render( $view = NULL, $output = "html" )
    {
        switch( $output ) {
            case "json":
                $this->output->set_content_type("application/json", "utf-8");
                if( $this->input->method(TRUE) == "POST" ) { $this->data['csrf_token'] =  $this->security->get_csrf_hash(); }
                echo json_encode($this->data);
                break;
            case "html":
                $this->load->view($view, $this->data);
                break;
            default: show_404(); break;
        }
    }
}
