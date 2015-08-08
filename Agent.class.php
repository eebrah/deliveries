<?php

require_once( "Base.class.php" );

Class Agent extends Base {
	
	private $name;
	private $dateJoined;
	
	function setName( $name ) { $this -> name = $name; }
	function getName() { return $this -> name; }
	
	function setDateJoined( $dateJoined ) { $this -> dateJoined = $dateJoined; }
	function getDateJoined() { return $this -> dateJoined; }
	
	function save( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
INSERT INTO agentDetails (
	  uniqueID
	, name
	, dateJoined
)
VALUES (
	  "' . $this -> getUniqueID() . '"
	, "' . $this -> getName() . '"
	, "' . $this -> getDateJoined() . '"
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
	
	function load($returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT *
FROM agentDetails
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
	
	function update($returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
UPDATE agentDetails 
SET name = "' . $this -> getName() . '"
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
	
	public static function getAgents( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT uniqueID
FROM orderDetails
WHERE 1';

		switch( $returnType ) {
			
			case RETURN_DATA :
			default : {
				
				return [];
			
			}
			break;
			
			case RETURN_QUERY : {
				
				return $query;
			
			}
			break;
		
		}
	
	}
	
	function __construct( $uniqueID = "00000",
	                      $name = "",
	                      $dateJoined = "0000-00-00 00:00:00" ) {
		
		parent::__construct( $uniqueID );
		
		if( $uniqueID === "00000" ) {
			
			$this -> setName( $name );
			$this -> setDateJoined( $dateJoined );
		
		}
		else {
			
			$this -> load();
		
		}
	
	}

}

?>
