<?php

require_once( "Agent.class.php" );
require_once( "Order.class.php" );
require_once( "Delivery.class.php" );

$output = '';

$pageTitle = 'Sapient Systems : deliveries prototype';

$pageHeader = '
<!DOCTYPE html>
<html>
	<head>
	<meta name="viewport" 
	      content="width=device-width" />
		<title>' . $pageTitle . '</title>
	</head>
	<body>
		<div class="wrapper">
			<div class="header"></div>
			<div class="nav">
				<ul>
					<li>
						<a href="?section=deliveries">deliveries</a>
					</li>
					<li>
						<a href="?section=orders">orders</a>
					</li>
					<li>
						<a href="?section=agents">agents</a>
					</li>
					<li>
						<a href="?section=users">users</a>
					</li>
				</ul>
			</div>
			<div class="body">';
			
$pageFooter = '</div>
			<div class="footer"></div>
		</div>
	</body>
</html>';

$pageBody = '';


const DIALOG_INFO = 0;
const DIALOG_ERROR = 1;
const DIALOG_SUCCESS = 2;

$dialogTypes = [ "info", "error", "success" ];

function Dialog( $dialogType = DIALOG_INFO, $message = "" ) {
	
	GLOBAL $dialogTypes;
	
	return '
<div class="dialog ' . $dialogTypes[ $dialogType ] . '">
	<p>' . $message . '</p>
</div>';

}


$section = "home";

if( isset( $_REQUEST[ "section" ] ) ) { $section = $_REQUEST[ "section" ]; }

switch( $section ) {
	
	case "home" :
	default : {
		
		$pageBody .= '<p>delivery management system prototype</p>';
	
	}
	break;
	
	case "deliveries" : {
		
		$pageBody .= '
<h1>deliveries</h1>';
	
		$action = "list";
		
		if( isset( $_REQUEST[ "action" ] ) ) { $action = $_REQUEST[ "action" ]; }
		
		switch( $action ) {
			
			case "list" :
			default : {
				
				$deliveries = Delivery::getDeliveries();
				
				if( count( $deliveries ) > 0 ) {
					
					$pageBody .= '
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>order ID</th>
			<th>agent</th>
			<th>actions</th>
		</tr>
	</thead>
	<tbody>';
	
					$count = 1;
	
					foreach( $deliveries as $deliveryID ) {
						
						$delivery = new Delivery( $deliveryID );
						
						$agent = new Agent( $delivery -> getAgent() );
						
						$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $delivery -> getOrder() . '</td>
			<td>' . $agent -> getName() . '</td>
			<td>
				<ul>
					<li>
						<a href="?section=deliveries&amp;action=view&amp;target=' . $deliveryID . '">view</a>
					</li>
					<li>
						<a href="?section=deliveries&amp;action=edit&amp;target=' . $deliveryID . '">edit</a>
					</li>
				</ul>
			</td>
		</tr>';
		
						$count++;
		
					}
					
					$pageBody = '
	</tbody>
</table>';
				
				}
				else {
					
					$pageBody .= dialog( DIALOG_INFO, "no entries to list" );
				
				}
			
			}
			break;
		
			case "add" : {
				
				if( isset( $_POST[ "orderID" ] ) ) {}
				else {
					
					$pageBody .= '
<div class="dialog">
	<h1>new delivery</h1>
	<form action="">
		<fieldset class="info">
			<legend>details</legend>
			<div class="row">
				<label for="orderID">order</label>
				<input type="text"
				       name="orderID"
				       required="required" />
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">reset</button>
			<button type="submit">submit</button>
		</fieldset>
	</form>
</div>';
				
				}
			
			}
			break;
			
			case "view" : {}
			break;
			
			case "edit" : {}
			break;
		
		}
	
	}
	break;
	
	case "orders" : {
		
		$pageBody = '<h1>Orders</h1>';
		
		$action = "list";
		
		if( isset( $_REQUEST[ "action" ] ) ) { $action = $_REQUEST[ "action" ]; }
		
		switch( $action ) {
		
			case "list" : {
				
				$orders = Order::getOrders();
				
				if( count( $orders ) > 0 ) {
					
					$pageBody .= '
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>pick up time</th>
			<th>drop off time</th>
			<th>actions</th>
		</tr>
	</thead>
	<tbody>';
	
					$count = 1;
					
					foreach( $orders as $orderID ) {
						
						$order = new Order( $orderID );
	
						$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $order -> getPickUpTime() . '</td>
			<td>' . $order -> getDropOffTime() . '</td>
			<td></td>
		</tr>';
		
						$count++;
		
					}
		
					$pageBody .= '
	</tbody>
</table>';
				
				}
				else {
					
					$pageBody .= dialog( DIALOG_INFO, "no orders to view" );
				
				}
			
			}
			break;
			
			case "add" : {
				
				if( isset( $_POST[ "pickUpTime" ] ) && isset( $_POST[ "pickUpPoint" ] ) && isset( $_POST[ "dropOffPoint" ] ) && isset( $_POST[ "dropOffTime" ] ) ) {
					
					$order = new Order( DEFAULT_UNIQUE_ID, $_POST[ "pickUpTime" ], $_POST[ "dropOffTime" ], $_POST[ "pickUpPoint" ], $_POST[ "dropOffPoint" ], $_POST[ "description" ] );
					
					$pageBody .= '<pre>' . $order -> save( RETURN_QUERY ) . $order -> update( RETURN_QUERY ) . '</pre>';
					
				}
				else {
					
					$pageBody .= '
<div class="dialog">
	<h1>new order</h1>
	<form action="?section=orders&amp;action=add"
	      method="post">
		<fieldset class="info">
			<legend>details</legend>
			<div class="row">
				<label for="pickUpPoint">pick up point</label>
				<textarea name="pickUpPoint"
				          required="required"
				          placeholder="Where is the item to be picked up from?"></textarea>
			</div>
			<div class="row">
				<label for="pickUpTime">pick up time</label>
				<input type="datetime"
				       name="pickUpTime"
				       placeholder="can be picked up as from ..." />
			</div>
			<div class="row">
				<label for="dropOffPoint">drop off point</label>
				<textarea name="dropOffPoint"
				          required="required"
				          placeholder="Where is the item to be dropped off"></textarea>
			</div>
			<div class="row">
				<label for="dropOffTime">drop off time</label>
				<input type="datetime"
				       name="dropOffTime"
				       placeholder="to be delivered by ..."
				       required="required" />
			</div>
			<div class="row">
				<label for="description">description</label>
				<textarea name="description"
				          placeholder="any extra pertinent information such as weight, size and any handling instructions"></textarea>
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">reset</button>
			<button type="submit">submit</button>
		</fieldset>
	</form>
</div>';
				
				}
				
			}
			break;
			
			case "edit" : {
				
			
			
			}
			break;
			
			case "view" : {
				
				if( isset( $_REQUEST[ "target" ] ) ) {
					
					$order = new Order( $_REQUEST[ "target" ] );
					
					$pageBody .= '<pre>' . $order -> save( RETURN_QUERY ) . $order -> update( RETURN_QUERY ) . '</pre>';
					
				}
				else {
					
					$pageBody .= Dialog( DIALOG_ERROR, 'no target specified' );
				
				}
			
			}
			break;
			
			case "delete" : {}
			break;
		
		}
	
	}
	break;
	
	case "agents" : {
		
		$pageBody = '<h1>agents</h1>';
		
		$action = "list";
		
		if( isset( $_REQUEST[ "action" ] ) ) { $action = $_REQUEST[ "action" ]; }
	
		switch( $action ) {
		
			case "list" :
			default : {
				
				$agents = Agent::getAgents();
				
				if( count( $agents ) > 0 ) {
					
					$pageBody = '
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>name</th>
			<th>since</th>
			<th>deliveries</th>
			<th>rating</th>
			<th>actions</th>
		</tr>
	</thead>
	<tbody>';
	
					foreach( $agents as $agentID ) {
						
						$agent = new Agent( $agentID );
		
						$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $agent -> getName() . '</td>
			<td>' . $agent -> getDateJoined() . '</td>
			<td>' . $agent -> getDeliveries() . '</td>
			<td>' . $agent -> getRating() . '</td>
			<td>
				<ul>
					<li>
						<a href="?section=agents&amp;action=view&amp;target=' . $agentID . '">view</a>
					</li>
					<li>
						<a href="?section=agents&amp;action=edit&amp;target=' . $agentID . '">edit</a>
					</li>
				</ul>
			</td>
		</tr>';
		
		
					}
				
					$pageBody .= '
	</tbody>
</table>';
				
				}
				else {
					
					$pageBody = dialog( DIALOG_INFO, "no agents listed" );
				
				}
			
			}
			break;
			
			case "add" : {
				
			}
			break;
			
			case "edit" : {}
			break;
			
			case "view" : {}
			break;
			
			case "delete" : {}
			break;
		
		}
	
	}
	break;

}


$format = "html";

if( isset( $_REQUEST[ "format" ] ) ) { $format = $_REQUEST[ "format" ]; }

switch( $format ) {
	
	case "html" :
	default : {
		
		$output = $pageHeader . $pageBody . $pageFooter;
	
	}
	break;
	
	case "ajax" : {
		
		$output = $pageBody;
	
	}
	break;

}

echo $output;

?>
