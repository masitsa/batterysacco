<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migrate extends CI_Controller
{
    public function index($version = NULL)
	{
		$this->load->library("migration");
		
		if($version != NULL)
		{
			if(!$this->migration->version($version))
			{
				show_error($this->migration->error_string());
			}
		}
		
		else
		{
			if ( ! $this->migration->current())
			{
				show_error($this->migration->error_string());
			}
		}
    }
}