<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pageloader extends CI_Controller {

    // loads index page
    public function index() {
        // get the users chosen language
        $idiom = $this->session->get_userdata('lang');
        if (empty($idiom['lang'])) {
            $this->session->set_userdata('lang','english');
            $idiom = $this->session->get_userdata('lang');
        }
        // load chosen language
        $this->lang->load('nature',$idiom['lang']);
        $this->load->view('nature/index');
    }

    // loads second (users) page
    public function userpage() {
        if (!isset($this->session->userdata['userid'])) {
            redirect('/ ');
        } else {
            $idiom = $this->session->get_userdata('lang');
            // load chosen language
            $this->lang->load('nature',$idiom['lang']);
            $this->load->model('nature');
            $data['coordinates'] = $this->nature->findcoordinates($this->session->userdata('userid'));
            $this->load->view('nature/userpage', $data);
        }
    }

    // allows change language
    public function change($type) {
    	$this->session->set_userdata('lang',$type);
        // stay at the same page
        if(!empty($_SERVER['HTTP_REFERER'])){
            redirect($_SERVER['HTTP_REFERER']);
        } else {
           redirect("", "refresh");
        }
    }
}
