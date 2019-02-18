<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

    public function method_get()
    {
        $this->data['status'] = FALSE;

        if( ! $this->input->get("name") ) {
            $this->data['field'] = "name";
            $this->data['message'] = "NAME REQUIRED";
        } else {
            $this->data['status'] = TRUE;
            $this->data['message'] = $this->input->get("name");
        }

        $this->render(NULL, "json");
    }

    public function method_post()
    {
        $this->data['status'] = FALSE;

        if( ! $this->input->post("name") ) {
            $this->data['field'] = "name";
            $this->data['message'] = "NAME REQUIRED";
        } else {
            $this->data['status'] = TRUE;
            $this->data['message'] = "HELLO, " . $this->input->post("name");
        }

        $this->render(NULL, "json");
    }

    public function method_post_multipart()
    {
        $this->data['status'] = FALSE;

        if( ! $this->input->post("name") ) {
            $this->data['field'] = "name";
            $this->data['message'] = "NAME REQUIRED";
        } else if( ! isset($_FILES['file']) ) {
            $this->data['message'] = "FILE(IMAGE) REQUIRED";
        } else {
            // $_FILES PROCESS

            $this->data['status'] = TRUE;
            $this->data['message'] = "HELLO, " . $this->input->post("name") . ", " . $_FILES['file']['name'];
        }

        $this->render(NULL, "json");
    }

}
