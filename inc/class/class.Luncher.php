<?php

require_once( 'class.Base.php' );

class Luncher extends Base {
	
	private $data = false;
	public $dataOut = false;
	public $total = 0;
	
	public function __construct( $data ) {
		$this->data = $data;
//		$this->dataOut = $this->data;
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
	
	private function setTotal( $amount ) {
		$this->total = $amount;
	}
	
	public function getTotal() {
		return $this->total;
	}
	
	// get open by store and day
	public function getOpen( $store, $dayInput ) {
		$result = false;
		foreach ( $this->getStoreOpenings( $store ) as $day => $openings ) {
			if( $day === $dayInput ) {
				$amount = count( $openings );
//				$now = time();
				$now = strtotime( '12:31' ); // debug
				// Has open today?
				if( $amount === 0 ) return $result;
				if ( $amount > 2 ) {
					// we have more than one open and close time
					if( $now >= strtotime( $openings[0] ) && $now <= strtotime( $openings[1] ) ) {
						$result = $openings[0] . ' - ' . $openings[1] . '<br />' . $openings[2] . ' - ' . $openings[3];
					} else if( $now >= strtotime( $openings[2] ) && $now <= strtotime( $openings[3] ) ) {
						$result = $openings[2] . ' - ' . $openings[3];
					} else {
						unset( $this->dataOut[ $store ] );
					}
				} else {
					// only one open and close times
					// is now between open and close 
					if( $now >= strtotime( $openings[0] ) && $now <= strtotime( $openings[1] ) ) {
						$result = $openings[0] . ' - ' . $openings[1];
					} else {
						unset( $this->dataOut[ $store ] );
					}
				}
			} // wrong day
		}
		// set new object data
		if( $result ) {
			$this->dataOut[ $store ] = $this->data[ $store ];
			$this->dataOut[ $store ]->geöffnet = $result;
		}
		$this->setTotal( count($this->dataOut) );
		return $result;
	}
	
	// get opening hours by store id
	private function getStoreOpenings( $store ) {
		$result = null; 
		foreach ( $this->data as $id => $location ) {
			if( $store === $id ) {
				foreach ( $location as $key => $value ) {
					if( $key === 'geöffnet' ) {
						foreach ( $value as $day => $openingHours ) {
							$result[ $day ] = $openingHours;
						}
					}
				}
			}
		}
		return $result;
	}
	
	public function getLocations() {
		$result = false;
		foreach ( $this->data as $id => $location ) {
			if( $this->getOpen( $id, Base::germanDay( date( 'D' ) ) ) ) {
				$result[ $id ] = $location;
			}
		}
		return $result;
	}
	
	public function getRandLocation() {
		return $this->dataOut[ ( rand( 0, count( $this->data ) -1 ) ) ];
	}
	
	public function getSub( $term ) {
		return $this->getUnique( $term );
	}
	
	private function getUnique( $search ) {
		if( ! is_array( $this->dataOut ) ) return false;
		$result = array();
		foreach ( $this->dataOut as $id => $location ) {
			// each element
			if( is_array( $location ) || is_object( $location ) ) {
				foreach ( $location as $key => $value ) {
					if( $key === $search ) {
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
		return count( $result ) === 0 ? false : $result;
	}
	
}

?>
