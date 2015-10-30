<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badge extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		header("location: " . site_url() . "/badge/generate_all");
	}

	public function generate_one($attendee_id){
		$this->load->model('attendee_model');
		$attendee_info = $this->attendee_model->get_attendee_info($attendee_id);
		$array_to_pass = array(
			'attendee_info' => $attendee_info
		);
		$this->load->view('single_badge_view' , $array_to_pass);
	}

	public function generate_all(){
		$this->load->model('attendee_model');
		$all_IDs = $this->attendee_model->get_all_attendee_IDs();
		foreach($all_IDs AS $an_ID){
			$this->generate_one($an_ID);
		}
		echo "<h1>Generated " . count($all_IDs) . " badges <br /></h1>\n";
	}
}