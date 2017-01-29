<?php

require_once( 'class.Base.php' );

class Luncher extends Base {
	
	public $data = false;
	
	public function __construct( $data ) {
		$this->data = $data;
	}
	
	public function getTags() {
		return Base::buildCheckboxes( $this->getSub( 'tags' ) );
	}
	
	public function getAngebote() {
		return Base::buildCheckboxes( $this->getSub( 'angebote' ) );
	}
	
	public function getEntfernungen() {
		return Base::buildCheckboxes( $this->getSub( 'entfernung' ) );
	}
	
	public function getLocations() {
		return $this->data;
	}
	
	public function getRandLocation() {
		return $this->data[ ( rand( 0, count( $this->data ) -1 ) ) ];
	}
	
	public function getSub( $term ) {
		return $this->getUnique( $term );
	}
	
	private function getUnique( $search ) {
		if( ! is_array( $this->data ) ) return false;
		$result = array();
		foreach ( $this->data as $id => $location ) {
			// each element
			if( is_array( $location ) || is_object( $location ) ) {
				foreach ( $location as $key => $value ) {
					if( $key == $search ) {
						if( is_array( $value ) ) {
							foreach ( $value as $skey => $svalue ) {
								if( ! in_array( $svalue, $result ) ) {
									array_push( $result, $svalue );
								}
							}
						} else {
							if( ! in_array( $value, $result ) ) {
								array_push( $result, $value );
							}
						}
					}
				}
			} 
		}
		return count( $result ) == 0 ? false : $result;
	}
	
}

?>
