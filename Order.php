<?php

require_once( "Base.class.php" );

Class Order extends Base {
	
	private $pickUpPoint;
	private $dropOffPoint;
	
	private $pickUpTime;
	private $dropOffTime;
	
	private $description;
	
	function setPickUpTime( $pickUpTime ) { $this -> pickUpTime = $pickUpTime; }
	function getPickUpTime() { return $this -> pickUpTime; }

	function setDropOffTime( $dropOffTime ) { $this -> dropOffTime = $dropOffTime; }
	function getDropOffTime() { return $this -> dropOffTime; }

	function setPickUpPoint( $pickUpPoint ) { $this -> pickUpPoint = $pickUpPoint; }
	function getPickUpPoint() { return $this -> pickUpPoint; }

	function setDropOffPoint( $dropOffPoint ) { $this -> dropOffPoint = $dropOffPoint; }
	function getDropOffPoint() { return $this -> dropOffPoint; }

	function setDescription( $description ) { $this -> description = $description; }
	function getDescription() { return $this -> description; }
	
	function save( $returnType ) {
	
		$query = '
INSERT INTO OrderDetails (
	  uniqueID
	, pickUpTime
	, dropOffTime
	, pickUpPoint
	, dropOffPoint
	, description
)
VALUES (
	  "' . $this -> getUniqueID() . '"
	, "' . $this -> getPickUpTime() . '"
	, "' . $this -> getDropOffTime() . '"
	, "' . $this -> getPickUpPoint() . '"
	, "' . $this -> getDropOffPoint() . '"
	, "' . $this -> getDescription() . '"
)';

		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
				
				
			}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
	}
	
	function load() {
		
		$query = '
SELECT *
FROM orderDetails
WHERE uniqueID = "' . $this -> getUniqueID() . '"';
	
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
				
				
			}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}	
	
	}
	
	function update() {
		
		$query = '
UPDATE orderDetails
SET
	  pickUpTime = "' . $this -> getPickUpTime() . '"
	, dropOffTime = "' . $this -> getDropOffTime() . '"
	, pickUpPoint = "' . $this -> getPickUpPoint() . '"
	, dropOffPoint = "' . $this -> getDropOffPoint() . '"
	, description = "' . $this -> getDescription() . '"
WHERE uniqueID = "' . $this -> getUniqueID() . '"';
	
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
				
				
			}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
	}
	
	public static function getOrders() {
		
		return [];
	
	}
	
	function __construct( $uniqueID = "00000",
	                      $pickUpTime = "0000-00-00 00:00:00",
	                      $dropOffTime = "0000-00-00 00:00:00",
	                      $pickUpPoint = "",
	                      $dropOffPoint = "",
	                      $description = "" ) {
	
		parent::__construct( $uniqueID );
		
		if( $uniqueID === "00000" ) {
			
			$this -> setPickUpTime( $pickUpTime );
			$this -> setDropOffTime( $dropOffTime );
			$this -> setPickUpPoint( $pickUpPoint );
			$this -> setDropOffPoint( $dropOffPoint );
			$this -> setDescription( $description );
			
		}
		else {
			
			$this -> load();
		
		}
							  
	}

}

?>
