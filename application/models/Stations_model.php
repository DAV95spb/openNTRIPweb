<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stations_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getAllStations()
  {
    $query = $this->db->query("SELECT * FROM stations LEFT JOIN stations_info ON stations.id = stations_info.id");
    $result = $query->result_array();

    return $result;
  }

  public function getStationByName($id){
    $query = $this->db->query("SELECT * FROM stations LEFT JOIN stations_info ON stations.id = stations_info.id WHERE stations.id =" .(int)$id);
    $result = $query->row();

    return $result;
  }

  public function setNewStation($arr)
  {
      $mountpoint =  $this->db->escape($arr['mountpoint']);
      $nmea =  $arr['nmea'] == 'on' ? '1' : '0';
      $authentication =  $arr['authentication'] == 'on' ? '1' : '0';
      $misc = $this->db->escape($arr['misc']);
      $sql = "INSERT INTO ntrip.stations (`id`,`mountpoint`,`nmea`,`authentication`,`misc`) VALUES (DEFAULT, ?, ?, ?, ?)";

      if($this->db->query($sql, array($mountpoint, $nmea, $authentication, $misc) )){
        return 'OK';
      }else{
        return $this->db->error(); // Has keys 'code' and 'message'
      }
  }
}
