<?php

class Geocoding {
	
	// Google API-KEY must replace by own api key:
	// https://developers.google.com/maps/documentation/geocoding/intro?csw=1
	
	private $address = null;
	private $apiKey = null; 
	private $apiUrl = null;
	private $apiTyp = null; // (json|xml)
	
	public function __construct( $address, $apiKey ) {
		$this->address = $address;
		$this->apiKey = 'xxx';
		$this->apiUrl = "http://maps.google.com/maps/api/geocode/";
		$this->apiTyp = 'json';
		
	}
	
	// http://stackoverflow.com/a/24778057
	public static function linkTo( $lat = '', $long = '', $zoom = '', $name = null ) {
		$arr1 = array( ' ', '&' );
		$arr2 = array( '+', '%26' );
		if( $name != null ) $url = 'maps/place/' . str_replace( $arr1, $arr2, $name ) . "/@$lat,$long," . $zoom . "z";
			else if( $name != '' ) $url = "maps?t=m&q=loc:$lat,$long&z=$zoom&near=$name";
			else $url = "maps?t=m&q=loc:$lat,$long&z=$zoom";
//		return "comgooglemaps://?center=$lat,-$long&zoom=19"
		 return "http://maps.google.com/" . $url;
	}
	
	private static function apiCall() {
		$url = $this->apiUrl . $this->apiTyp . '?address=' . $this->address . '&key=' . $this->apiKey;
		
		// http://maps.google.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA
	}
	
	private static function toGurl() {
		if( ! is_array( $this->address ) ) return false;
		
		// return address as url string
		
		// http://maps.google.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA
	}
	
}

?>

