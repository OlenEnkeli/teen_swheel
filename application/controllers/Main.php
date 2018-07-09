<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
			parent::__construct();

			$this->load->library('encryption');
			$this->load->library('session');

			$this->encryption->initialize(
        array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => 'f74Fbhfk48f74Fbhfk48f74Fbhfk4832'
        )
			);

	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function register()
	{
		$this->load->model('person_model','',TRUE);

		$login_exists = $this->person_model->login_exists($this->input->post('login'));
		$email_exists = $this->person_model->email_exists($this->input->post('email'));

		if (!($login_exists  and $email_exists) )
			$this->person_model->register();


		echo json_encode(array('loginExists' => $login_exists, 'emailExists' => $email_exists));
	}

	public function login()
	{
		if (!$this->session->login)
		{
			$this->load->model('person_model','',TRUE);
			$login_and_password_exists = $this->person_model->login();
			$login_and_password_exists ? $ans =  json_encode(array('loginAndPasswordExist' => true)) : $ans = json_encode(array('loginAndPasswordExist' => false)) ;
			echo $ans;

			if ($login_and_password_exists)
			{
				$this->session->set_userdata(
					array (
						'login'=>$login_and_password_exists,
					)
				);
			}

		}
	}

	public function get_coords()
	{
		$this->load->model('person_coords_model','',TRUE);
		if ($this->session->login)
		{
			$arr = $this->person_coords_model->get_coords();
			if ($arr)
				echo json_encode($arr);

		}
	}

	public function put_coords()
	{
		$this->load->model('person_coords_model','',TRUE);
		echo $this->person_coords_model->set_coords();
	}

}
