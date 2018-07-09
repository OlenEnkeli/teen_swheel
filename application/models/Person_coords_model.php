<?php
class Person_coords_model extends CI_Model
{
  public $lattitude;
  public $longtitude;
  public $person_id;

  public function __construct()
  {
    parent::__construct();
  }

  public function get_coords()
  {
    if ($this->session->login)
		{
			$this->db->where(array('person_id'=>$this->session->login),1);
			$query = $this->db->get('person_coords');
			$row = $query->result();
      if ($row)
      {
        $arr =  array('lattitude' => $row[0]->lattitude, 'longitude' => $row[0]->longitude);
        return $arr;
      }
      else {
        return false;
      }
		}
  }

  public function set_coords()
  {
    if ($this->session->login)
    {
      $this->db->where(array('person_id'=>$this->session->login),1);
      $this->db->update('person_coords',array(
        'lattitude'=>$this->input->post('lattitude'),
        'longitude'=>$this->input->post('longitude')
      ));
      return json_encode(array('success'=>true));
    } else {
      return json_encode(array('success'=>false));
    }
  }
}


 ?>
