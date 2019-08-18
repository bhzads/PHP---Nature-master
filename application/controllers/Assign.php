<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign extends CI_Controller {
    public function index() {
        // get the users chosen language
        $idiom = $this->session->get_userdata('lang');
        if (empty($idiom['lang'])) {
            $this->session->set_userdata('lang','english');
            $idiom = $this->session->get_userdata('lang');
        }
        // load chosen language
        $this->lang->load('nature',$idiom['lang']);
        // temporay function that sets default user id, befor the page is connected to real payment page
        if (null === $this->session->userdata('userid')) {
            $this->session->set_userdata('userid', 1);
            $this->session->set_userdata('username', 'Cat');
        }
        $this->load->view('nature/assign');
    }
    // save location of click
    public function savelocation() {
        $data = array(
            'latitude' => $this->input->post('lat'),
            'longitude' => $this->input->post('long')
        );
        $this->session->set_userdata('newlocation', $data);
    }
    // push all new location data to database
    public function write() {
        $newlocation = $this->session->userdata('newlocation');
        $this->load->model('nature');
        //create new location
        $this->nature->pushlocation($newlocation);
        // get new location id
        $locationid = $this->nature->getlocationid($newlocation['latitude'], $newlocation['longitude']);
        // set user id and location id
        $data = array(
            'users_id' => $this->session->userdata('userid'),
            'location_id' => $locationid['id'],
            // sqm should be taking from payment form, temporary default value set to 10
            'sqm' => 10//$this->session->userdata('sqm')
        );
        // push user id + location;
        $this->nature->connectuserlocation($data);
        redirect('/pageloader/userpage');
    }
}
