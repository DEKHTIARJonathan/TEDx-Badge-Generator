<?php
header('Content-Type: text/html; charset=utf-8');

	if ( ! function_exists('properText')){
		function properText($text){
			# detect if the string was passed in as unicode
			$text_encoding = mb_detect_encoding($text, 'UTF-8, ISO-8859-1');
			# make sure it's in unicode
			if ($text_encoding != 'UTF-8') {
			    $text = mb_convert_encoding($text, 'UTF-8', $text_encoding);
			}

			# html numerically-escape everything (&#[dec];)
			$text = mb_encode_numericentity($text, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');

			return $text; 
		}
	}

	if ( ! function_exists('put_attendee_name')){
		function put_attendee_name($image_resource , $attendee_name){
			$font_size = 52; 
			$x_pos = NULL;
			$y_pos = 370;
			__write_the_DAMN_text(
				$image_resource , properText($attendee_name) , 
				"black" , "helvetica-neue" , $font_size , 
				$x_pos , $y_pos
			);
		}
	}

	if ( ! function_exists('put_organization_designation')){
		function put_organization_designation($image_resource , $organization_designation){
			$font_size = 28; 
			$x_pos = NULL;
			$y_pos = 440;
			__write_the_DAMN_text(
				$image_resource , properText($organization_designation) , 
				"black" , "helvetica-neue" , $font_size , 
				$x_pos , $y_pos
			);
		}
	}

	if ( ! function_exists('__write_the_DAMN_text')){
		function __write_the_DAMN_text($image_resource , $text_to_write , $font_color , $font_face , $font_size , $x_pos , $y_pos){
			$text_to_write = trim($text_to_write);
			//--------------------------------------------------------------------
			$color_palette = array(
				"black" => imagecolorallocate($image_resource, 0, 		0, 		0),
				"white" => imagecolorallocate($image_resource, 255,		255,	255),
			);
			$color_resource = $color_palette[$font_color];
			//--------------------------------------------------------------------
			$font_file_paths = array(
				"helvetica-neue" 		=>	"./resources/helvetica-neue.ttf"
			);
			$font_file_path	= $font_file_paths[$font_face];
			//--------------------------------------------------------------------
			$text_angle = 0;
			//--------------------------------------------------------------------
			if (is_null($x_pos)){
				$text_image_coords 	= imagettfbbox(
										$font_size, 
										$text_angle , 
										$font_file_path , 
										$text_to_write
									);
				$text_width 		= $text_image_coords[2] - $text_image_coords[0];
				while ($text_width > 1000){
					$font_size -= 2;
					$text_image_coords 	= imagettfbbox(
										$font_size, 
										$text_angle , 
										$font_file_path , 
										$text_to_write
									);
					$text_width 	= $text_image_coords[2] - $text_image_coords[0];
				}
				$text_center_x			= $text_width / 2;
				$certificate_width		= imagesx($image_resource);
				$certificate_height		= imagesy($image_resource);
				$certificate_center_x 	= $certificate_width / 2;
				$center_displacement	= $certificate_center_x - $text_center_x;
				$x_pos = $center_displacement;
			}
			else {$x_pos = $x_pos;}
			$y_pos = $y_pos;
			//--------------------------------------------------------------------
			// write the text
			imagettftext(
				$image_resource, 
				$font_size, 
				$text_angle, 
				$x_pos, $y_pos, 
				$color_resource, 
				$font_file_path, 
				$text_to_write
			);
		}
	}

	ini_set('display_errors', 1);
	$attendee_id 				= $attendee_info['id'];
	$attendee_name 				= $attendee_info['full_name'];
	$designation 				= $attendee_info['designation'];
	$organization				= $attendee_info['organization'];
	$organization_designation	= "$designation - $organization";
	$talk2me_1					= $attendee_info['talk2me_1'];
	$talk2me_2					= $attendee_info['talk2me_2'];
	$talk2me_3					= $attendee_info['talk2me_3'];
	$talk2me_about_line			= "$talk2me_1   |   $talk2me_2   |   $talk2me_3";
	//--------------------------------------------------------------------
	$source_dir		= './resources/';
	$source_file 	= "badge_template.png";
	$source_path	= $source_dir . $source_file;
	//--------------------------------------------------------------------
	$image_resource = imagecreatefrompng($source_path);
	put_attendee_name($image_resource , $attendee_name);
	put_organization_designation($image_resource , $organization_designation);
	//--------------------------------------------------------------------
	if ($shall_produce_output_file = TRUE){
		$output_directory_name = "output";
		if ( ! file_exists($output_directory_name)) {
			mkdir($output_directory_name);
		}
		$output_filename = "$output_directory_name/$attendee_id.png";
		$final_echo = "<img src='" . base_url() . $output_filename . "'><br /><hr />";
		header('Content-type: text/html');
	}
	else {
		/* we are only TESTING the output result */
		$output_filename = NULL;
		$final_echo = NULL;
		header('Content-type: image/png');
	}
	//--------------------------------------------------------------------
	imagepng($image_resource , $output_filename);
	imagedestroy($image_resource);
	echo $final_echo;
	//--------------------------------------------------------------------