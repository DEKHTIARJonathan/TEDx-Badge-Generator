<?php
	header("Content-Type: text/html; charset=UTF-8"); 
    ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
  
    require_once 'database/dbconnect.php';

class Attendee_model extends CI_Model {

	function get_attendee_info($attendee_id){

		$connect = SPDO::getInstance();
		$sth = $connect->prepare('SELECT * FROM `people` where `id_person` = :id');
	    $sth->bindParam(':id', $attendee_id);
	    
	    $sth->execute();
	    
	    $row = $sth->fetch();

		return array(
			"id"			=>	$row['id_person'],
			"full_name" 	=> 	$row['prenom'].' '.$row['nom'],
			"designation"	=> 	$row['poste'],
			"organization"	=>	$row['entreprise'],
			"talk2me_1"		=>	"Startups",
			"talk2me_2"		=>	"KungFu",
			"talk2me_3"		=>	"Ice Buckets"
		);
	}

	function get_all_attendee_IDs(){
		$connect = SPDO::getInstance();
		$sth = $connect->prepare('SELECT `id_person` FROM `people` order by `id_person`');
	    //$sth->bindParam(':login', $login);
	    
	    $sth->execute();

	    $result = array();
	    
	    while ($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {

	         array_push($result, $row['id_person']);
	        
	    }

    	return $result;
	}
}