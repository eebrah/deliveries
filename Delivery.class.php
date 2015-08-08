<?php

require_once( "Base.class.php" );

Class Delivery extends Base {
	
	private $order;
	private $agent;
	
	private $pickUpTime;
	private $dropOffTime;
	
	function setOrder( $order ) { $this -> order = $order; }
	function getOrder() { return $this -> order; }
	
	function setAgent( $agent ) { $this -> agent = $agent; }
	function getAgent() { $this -> agent; }
	
	function setPickUpTime( $pickUpTime ) { $this -> pickUpTime = $pickUpTime; }
	function getPickUpTime() { return $this -> pickUpTime; }

	function setDropOffTime( $dropOffTime ) { $this -> dropOffTime = $dropOffTime; }
	function getDropOffTime() { return $this -> dropOffTime; }
	
	function save( $returnType = RETURN_BOOLEAN ) {
	
		GLOBAL $dbh;
		
		$query = '
INSERT INTO deliveryDetails ()
VALUES ();';
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
	}
	
	function load($returnType = RETURN_BOOLEAN ) {
	
		GLOBAL $dbh;
		
		$query = '
SELECT *
FROM deliveryDetails
WHERE uniqueID = "' . $this -> getUniqueID() . '";';
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
	}
	
	function update($returnType = RETURN_BOOLEAN ) {
	
		GLOBAL $dbh;
		
		$query = '
UPDATE deliveryDetails
SET
WHERE
	uniqueID = "' . $this -> getUniqueID() . '"';
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
	}
	
	public static function getDeliveries() {
		
		return [];
	
	}
	
	function __construct( $uniqueID = "00000",
	                      $order = "00000",
	                      $agent = "00000",
	                      $pickUpTime = "0000-00-00 00:00:00",
	                      $dropOffTime = "0000-00-00 00:00:00" ) {
		
		parent::__construct( $uniqueID );
		
		if( $uniqueID === "00000" ) {
			
			$this -> setOrder( $order );
			$this -> setAgent( $agent );
			
			$this -> setPickUpTime( $pickUpTime );
			$this -> setDropOffTime( $dropOffTime );
			
		}
		else {
		
			$this -> load();
		
		}
	
	}

}

?>
