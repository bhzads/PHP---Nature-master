<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    // load admin login page
    public function index() {
        $this->load->view('nature/admin_login');
    }

    public function login() {
        // validate input
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        if ($this->form_validation->run() === false) {
            //show error
			$this->session->set_flashdata('input_error', validation_errors());
            redirect('/admin/ ');
		}
        else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            // check if email is in database
            $this->load->model('nature');
            if ($this->nature->findAdmin($email)) {
                $admin = $this->nature->findAdmin($email);
                // compare passwords
                if ($admin['password'] == $password) {
                	$this->session->set_userdata('admin',true);
                    redirect('/admin/load');
                }
                else {
                    $this->session->set_flashdata('input_error', "Sorry, password is incorrect");
                    redirect('/admin/ ');
                }
            }
            else {
                $this->session->set_flashdata('input_error', "Sorry, email is not registered.");
                redirect('/admin/ ');
            }
        }
    }
    // load upload page
    public function load(){
        // check if admin is registered
    	if ($this->session->userdata('admin') !== true) {
    		redirect ('/admin/ ');
    	}
        $this->load->model('nature');
        $data['coordinates'] = $this->nature->getalllocations();
    	$this->load->view('nature/admin_upload', $data);
    }

    public function upload() {
        // validation
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required|decimal|min_length[6]|max_length[7]');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required|decimal|min_length[6]|max_length[7]');
        if ($this->form_validation->run() === false) {
            //show error
			$this->session->set_flashdata('image_error', validation_errors());
            redirect('/admin/load');
		}
        // check if location exists
        $lat = $this->input->post('latitude');
        $long = $this->input->post('longitude');
        $this->load->model('nature');
        // get location id
        $id['id'] = $this->nature->getlocationid($lat, $long);
        if (empty($id['id'])) {
            // push new location to database
            $location = array (
                'latitude' => $lat,
                'longitude' => $long
            );
            $this->nature->pushlocation($location);
            $id['id'] = $this->nature->getlocationid($lat, $long);
        }
        // store uploaded file
        $imagedata = $this->do_upload();
        // push image to database
        $image = array (
            'link' => '/img/pics/' . $imagedata['upload_data']['orig_name'],
            'location_id' => $id['id']['id']
        );
        $this->nature->uploadimage($image);
        $this->session->set_flashdata('image_error', 'Your file have been successfully added');
        redirect('/admin/load');
    }

    // upload images
    public function do_upload()
    {
        $config['upload_path']          = 'img/pics/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 30000;
        $config['max_width']            = 15000;
        $config['max_height']           = 15000;
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('image_error', $error);
        }
        else {
            return $data = array('upload_data' => $this->upload->data());
        }
    }
    // logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('/pageloader/ ');
    }
}
