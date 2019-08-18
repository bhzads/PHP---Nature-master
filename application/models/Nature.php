<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nature extends CI_Model {
    // returns user id and name, search by email
    public function finduser($postemail) {
        $query = "SELECT users.id, users.name FROM users WHERE email = ?;";
        return $this->db->query($query, $postemail)->row_array();
    }

    // returns locations and sq meters for certain user, search by user id
    public function findcoordinates($userid) {
        $query = "SELECT location.latitude, location.longitude, location.id, users_has_location.sqm
        FROM location
        INNER JOIN users_has_location
        ON users_has_location.location_id = location.id
        WHERE users_has_location.users_id = ?";
        return $this->db->query($query, $userid)->result_array();
    }

    // returns all images and videos for certain location, search by location id
    public function findmedia($locationid) {
        $query = "SELECT media.link
        FROM media
        WHERE media.location_id = ?";
        return $this->db->query($query, $locationid)->result_array();
    }

    // returns coordinates and ammoun of sqm adopted by user for certain location id
    public function getcoordinates($locationid) {
        $query = "SELECT location.latitude, location.longitude, users_has_location.sqm
        FROM location
        INNER JOIN users_has_location
        ON users_has_location.location_id = location.id
        WHERE location.id = ?";
        return $this->db->query($query, $locationid)->row_array();
    }

    // returns total ammount of sqm adopted by user
    public function calculatesqm($userid) {
        $query = "SELECT SUM(sqm) AS sum
        FROM users_has_location
        WHERE users_id = ?";
        return $this->db->query($query, $userid)->row_array();
    }

    // returns location id by coordinates
    public function getlocationid($latitude, $longitude) {
        $query = "SELECT location.id
        FROM location
        WHERE location.latitude = ? AND location.longitude = ?";
        return $this->db->query($query, array($latitude, $longitude))->row_array();
    }
    
    // inserts new location
    public function pushlocation($new) {
        $this->db->insert('location', $new);
    }

    // inserts new connection between user and location
    public function connectuserlocation($data){
        $this->db->insert('users_has_location', $data);
    }

    // admin page login
    public function findAdmin($email)
        {
            $query = 'SELECT * FROM admin WHERE admin_email = ?;';
            return $this->db->query($query,$email)->row_array();
        }

    // inserts new image
    public function uploadimage($array) {
        $this->db->insert('media', $array);
    }

    // get all locations
    public function getalllocations() {
        $query = "SELECT location.latitude, location.longitude
        FROM location";
        return $this->db->query($query)->result_array();
    }
}
