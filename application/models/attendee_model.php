<?php

class Attendee_model extends CI_Model {

	function get_attendee_info($attendee_id){
		/* 	
		TODO: 
			fetch the row for that attendee_id from database
			and return that row in the following format 
		*/
		return array(
			"id"			=>	"023",
			"full_name" 	=> 	"SATTAR Mohammad",
			"designation"	=> 	"Senior Executive, Business Development",
			"organization"	=>	"Sheiram Group",
			"talk2me_1"		=>	"Startups",
			"talk2me_2"		=>	"KungFu",
			"talk2me_3"		=>	"Ice Buckets"
		);
	}

	function get_all_attendee_IDs(){
		/*
		TODO:
			fetch all attended IDs from database
			and return all of them in the following format
		*/
		return array(
			"001" , "002" , "003" , "004" , "005" , "006" , "007"
		);
	}
}