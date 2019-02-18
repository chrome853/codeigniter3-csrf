<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function method_get()
    {
        $data['status'] = FALSE;

        if( ! $this->input->get("name") ) {
            $data['field'] = "name";
            $data['message'] = "NAME REQUIRED";
        } else {
            $data['status'] = TRUE;
            $data['message'] = $this->input->get("name");
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function method_post()
    {
        $data['status'] = FALSE;

        if( ! $this->input->post("name") ) {
            $data['field'] = "name";
            $data['message'] = "NAME REQUIRED";
        } else {
            $data['status'] = TRUE;
            $data['message'] = "HELLO, " . $this->input->post("name");
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function method_post_multipart()
    {
        $data['status'] = FALSE;

        if( ! $this->input->post("name") ) {
            $data['field'] = "name";
            $data['message'] = "NAME REQUIRED";
        } else if( ! isset($_FILES['file']) ) {
            $data['message'] = "FILE(IMAGE) REQUIRED";
        } else {
            // $_FILES PROCESS

            $data['status'] = TRUE;
            $data['message'] = "HELLO, " . $this->input->post("name") . ", " . $_FILES['file']['name'];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

}
