<?php

class Tienda extends CI_Controller{
	
	
	function home()
	{
		$this->load->helper('url');
		
		$this->load->view("tienda/home");
	}
	
	function categoria($categoria_id)
	{
		
	}
	
	function detalle($producto_id)
	{
		
	}
	
}