<?php

require_once('class.Geocoding.php');

class Base {
	
	public static function buildCheckboxes( $element ) {
		$result = false;
		if( is_array($element) ) {
			foreach ( $element as $key => $value ) {
				$result[] = '<label class="btn btn-default"><input id="checkbox_'.$key.'" value="'.$value.'" type="checkbox" /> '.$value.' </label>';
			}
		}
		return $result;
	}
	
	public static function arr2label( $array ) {
		$result = '';
		if( is_array( $array ) ) {
			foreach ( $array as $key => $value ) {
//				$result .= self::arr2label( $value ) . " ";
				$result[] = '<label class="label label-default"><input id="label_'.$value.'_'.$key.'" value="'.$value.'" type="checkbox" /> <span class="glyphicon glyphicon-tag"></span> ' . $value . '</label>';
			}
		} 
//		else {
//			$result .= '<label class="label label-default"><input id="labelbox_'.$key.'" value="'.$value.'" type="checkbox" /> <span class="glyphicon glyphicon-tag"></span> ' . $array . '</label>';
//		}
		return self::arr2str( $result );
	}
	
	public static function arr2str( $array ) {
		$result = '';
		if( is_array( $array ) ) {
			foreach ( $array as $key => $value ) {
				$result .= self::arr2str( $value ) . " ";
			}
		} else {
			$result .= $array;
		}
		return $result;
	}
	
	public static function linkTo( $lat, $long, $zoom, $name ) {
		 return Geocoding::linkTo( $lat, $long, $zoom, $name );
	}
	
	public function germanDay( $day ) {
		if( $day == "" ) return null;
		$result = "";
		switch ($day)
		{
			case 'Tue':
				$result = "Die";
			break;
			case 'Wed':
				$result = "Mit";
			break;
			case 'Thu':
				$result = "Don";
			break;
			case 'Fri':
				$result = "Fre";
			break;
			case 'Sat':
				$result = "Sam";
			break;
			case 'Sun':
				$result = "Son";
			break;
			default:
				$result = $day;
			break;
		}
		return $result;
	}
	
}

?>
