<?php

class Tienda extends CI_Controller{
	
	
	function home()
	{
		$this->load->database();
		$this->load->helper('url');

		$view = array();	
		$query = $this->db->get('productos');

		$view["data"] = $query->result();

		$this->load->view("tienda/home",$view);
	}
	
	function categoria($categoria_id)
	{
		
	}
	
	function detalle($producto_id)
	{
		
	}
	
}