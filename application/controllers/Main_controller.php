<?php

class Main_controller extends CI_Controller {

	function index()
	{
		header('Location: '.base_url('home'));
	}

}