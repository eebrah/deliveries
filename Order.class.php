<?php

require_once( "Base.class.php" );

Class Order extends Base {
	
	private $pickUpPoint;
	private $dropOffPoint;
	
	private $pickUpTime;
	private $dropOffTime;
	
	private $description;
	
	private $userID;
	private $status;
	
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
	
	function setUserID( $userID ) { $this -> userID = $userID; }
	function getUserID() { return $this -> userID; }
	
	function setStatus( $status ) { $this -> status = $status; }
	function getStatus() { return $this -> status; }
	
	function save( $returnType = RETURN_BOOLEAN ) {
	
		$query = '
INSERT INTO orderDetails (
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
	
	function load( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT *
FROM orderDetails
WHERE uniqueID = "' . $this -> getUniqueID() . '"';
	
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
				
				try {

					$statement = $dbh -> prepare( $query );

					$statement -> execute();

					$row = $statement -> fetch();

					$this -> setPickUpTime( $row[ "pickUpTime" ] );
					$this -> setPickUpPoint( $row[ "pickUpPoint" ] );
					$this -> setDropOffTime( $row[ "dropOffTime" ] );
					$this -> setDropOffPoint( $row[ "dropOffPoint" ] );
					$this -> setDescription( $row[ "description" ] );
					$this -> setUserID( $row[ "userID" ] );
					$this -> setStatus( $row[ "status" ] );

					return true;

				}
				catch( PDOException $e ) {

				   print "Error[ 102 ]: " . $e -> getMessage() . "<br/>";
				   die();

				}
				
			}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}	
	
	}
	
	function update( $returnType = RETURN_BOOLEAN ) {
		
		$query = '
UPDATE orderDetails
SET
	  pickUpTime = "' . $this -> getPickUpTime() . '"
	, dropOffTime = "' . $this -> getDropOffTime() . '"
	, pickUpPoint = "' . $this -> getPickUpPoint() . '"
	, dropOffPoint = "' . $this -> getDropOffPoint() . '"
	, description = "' . $this -> getDescription() . '"
	, userID = "' . $this -> getUserID() . '"
	, status = "' . $this -> getStatus() . '"
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
	
	public static function getOrders( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT uniqueID
FROM orderDetails
WHERE 1';

		switch( $returnType ) {
			
			case RETURN_DATA :
			default : {
				
				return ["1S1VY", "46E3E"];
			
			}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
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
