<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

    // search data by email
    public function search() {
        // connect language for errors
        $idiom = $this->session->get_userdata('lang');
        $this->lang->load('nature',$idiom['lang']);
        // check if input is valid
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        if ($this->form_validation->run() === false) {
            //show error, redirect to index
            $this->session->set_flashdata('input_error', $this->lang->line('error_empty_email'));
            return 0;
        }
        else {
            // check if email is in database
            $email = $this->input->post('email');
            $this->load->model('nature');
            if ($this->nature->finduser($email)) {
                $user = $this->nature->finduser($email);
                // save userdata
                $this->session->set_userdata('username', $user['name']);
                $this->session->set_userdata('userid', $user['id']);
                return 1;
            }
            else {
                $this->session->set_flashdata('input_error', $this->lang->line('error_email'));
                return 0;
            }
        }
    }

    // check email for index page
    public function searchfirst() {
        if ($this->search() == 1) {
            redirect('/pageloader/userpage');
        }
        else {
            redirect("","refresh");
        }
    }

    // check email for user page
    public function searchsecond() {
        if ($this->search() == 1) {
            redirect('/pageloader/userpage');
        }
        else {
            redirect('/pageloader/userpage');
        }
    }

    // loads location page for certain location id
    public function locationdata($locationId) {
        // load chosen language
        $idiom = $this->session->get_userdata('lang');
        $this->lang->load('nature',$idiom['lang']);
        // gets all data for location
        $this->load->model('nature');
        $data['photos'] = $this->nature->findmedia($locationId);
        $data['coordinates'] = $this->nature->getcoordinates($locationId);
        $data['sum'] = $this->nature->calculatesqm($this->session->userdata['userid']);
        $this->load->view('nature/location', $data);
    }

    public function clicklocation() {
        $data = array(
            'lat' => $this->input->post('lat'),
            'long' => $this->input->post('long')
        );
        $this->session->set_userdata('location', $data);
    }

    public function lastlocation() {
        $location = $this->session->userdata('location');
        // find id the model
        $this->load->model('nature');
        $id = $this->nature->getlocationid($location['lat'], $location['long']);
        $this->locationdata($id);
    }
}
