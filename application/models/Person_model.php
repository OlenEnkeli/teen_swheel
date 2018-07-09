<?php
class Person_model extends CI_Model
{
  public $date;
  public $month;
  public $year;
  public $name;
  public $surname;
  public $login;
  public $password;
  public $email;
  public $sex;

  public function __construct()
  {
    parent::__construct();
  }

  public function login_exists($login)
  {
    $this->db->where(array('login'=>$login),1);
    $this->db->from('person');
    $login_exists = $this->db->count_all_results();

    if ($login_exists)
      return true;
    else
      return false;
  }

  public function email_exists($email)
  {
    $this->db->where(array('email'=>$email),1);
    $this->db->from('person');
    $login_exists = $this->db->count_all_results();

    if ($login_exists )
      return true;
    else
      return false;
  }


  public function register()
  {
    $this->date = $this->input->post('date');
    $this->month = $this->input->post('month');
    $this->year = $this->input->post('year');
    $this->name = $this->input->post('name');
    $this->surname = $this->input->post('surname');
    $this->login = $this->input->post('login');
    $this->password = $this->encryption->encrypt($this->input->post('password'));
    $this->email = $this->input->post('email');
    $this->sex = $this->input->post('sex');

    $this->db->insert('person', $this);

    $this->db->insert('percon_coord', array(
      'longitude'=>'NULL',
      'lattitude'=>'NULL',
      'user_id'=>$this->login
    ));
  }

  public function login()
  {
    $this->db->where(array('login'=>$this->input->post('login') ),1);
    $query = $this->db->get('person');
    $login_exists = $query->result();
    $db_password = $login_exists[0]->password;

    if ($login_exists and ($this->encryption->decrypt($db_password) == $this->input->post('password')) )
      return $login_exists[0]->login;
    else
      return false;
  }





}

 ?>
