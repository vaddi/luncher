<?php

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
				$result[] = '<label class="label label-default" data-toggle="tooltip" data-placement="right" title="'.$value.' zum Filter hinzufügen/entfernen"><input id="label_'.$value.'_'.$key.'" value="'.$value.'" type="checkbox" /> <span class="glyphicon glyphicon-tag"></span> ' . $value . '</label>';
			}
		} 
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
	
	public static function linkTo( $lat = '', $long = '', $zoom = '', $name = null ) {
		$arr1 = array( ' ', '&' );
		$arr2 = array( '+', '%26' );
		if( $name != null ) $url = 'maps/place/' . str_replace( $arr1, $arr2, $name ) . "/@$lat,$long," . $zoom . "z";
			else if( $name != '' ) $url = "maps?t=m&q=loc:$lat,$long&z=$zoom&near=$name";
			else $url = "maps?t=m&q=loc:$lat,$long&z=$zoom";
//		return "comgooglemaps://?center=$lat,-$long&zoom=19"
		 return "http://maps.google.com/" . $url;
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
	
	/** 
	 * Helper function to get version number from "git tag" 
	 * (dont forget to commit them with "git push origin TAG"!)
	 */
	public static function getVersion() {
		if( self::git() ) {
			if( is_file( '/usr/bin/git' ) ) 
				return exec( '/usr/bin/git describe --abbrev=0 --tags' );
		}
		return false;
	}
	
	private static function git() {
		if( is_dir( realpath( './.git' ) ) ) return true;
		return false;
	}
	
}

?>
