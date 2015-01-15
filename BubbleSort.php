<?php 


// Performs one step in the bubble sort process
function bubbleSort(&$items, &$pass, &$current, &$swap, &$done) {
	$size = count($items);
	
	// Compare
	if ($items[$current] < $items[$current + 1]) {
		arraySwap($items, $current, $current + 1);
		$swap = true;
	}

	$current++;
	if ($current == ($size - 1)) {
		// We have reached the end - set the values for the next pass
		$current = 0;
		$pass++;
		if ($pass == $size) {
			$done = true;
				
			return;
		}
	}
}


function arraySwap(&$arr, $index1, $index2) {
	list($arr[$index1], $arr[$index2]) = array($arr[$index2], $arr[$index1]);
}


function processArray($arr, $pass, $current) {
	// Convert the JSON to a PHP array
	$phpArray = json_decode($arr);
	
	$done = false;
	$swap = false;
	
	bubbleSort($phpArray, $pass, $current, $swap, $done);

	$retArray["arr"] = $phpArray;
	$retArray["pass"] = $pass;
	$retArray["current"] = $current;
	$retArray["done"] = $done;
	$retArray["swap"] = $swap;

	// Return the resulting array
	echo json_encode($retArray);
}

function shuff() {
	for ($i = 0; $i < 10; $i++) {
		$vector[$i] = mt_rand(0, 100);
	}
	
	// Return the resulting array
	echo json_encode($vector);

}

if(isset($_POST['action']) && !empty($_POST['action'])) {
	
	switch( $_POST['action'] )
	{
		case 'bubblesort':
			$arr = $_POST['array1'];
			$pass = $_POST['pass'];
			$current = $_POST['current'];
	
			processArray($arr, $pass, $current);
			
			break;
		case 'shuffle':
			shuff();
			
			break;
	}
	
} else {
?>

<!DOCTYPE html>
<html>
<head> 

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<style>
		.bar { width: 40%; border: 1px; }
		.percentage1, .percentage2, .percentage3, .percentage4, .percentage5, .percentage6, .percentage7, .percentage8, .percentage9, .percentage10 { background: #000; color:white; width:0%; }
	</style>

	<script>
	
		passNum = 0;
		currentNum = 0;
		currLocation = window.location.pathname;


		function init() {
			// Disable the Step button
			$("#btnStep").prop("disabled", true);
		

		}
		
		function shuff() {
			$.post(	currLocation,
					{action: 'shuffle'},
					function(data, statusText) {
						arr = JSON.parse(data);

						updateGraph(arr, -1, false);

						// enable the Step button
						$("#btnStep").prop("disabled", false);
					}
			);			
		}
		
		function step() {
			prevCurrent = currentNum;

			$.post(	currLocation,
					{action: 'bubblesort', 
					pass: passNum,
					current: currentNum,
					array1: JSON.stringify(arr)},
					function(data, statusText) {

						tempArr = JSON.parse(data);
						passNum = tempArr.pass;
						currentNum = tempArr.current;
						swap = tempArr.swap;
						done = tempArr.done;
						arr = tempArr.arr;

						updateGraph(arr, prevCurrent, swap, passNum);
						
					    
				    	if (done) {
							// Disable the Step button
				    		$("#btnStep").prop("disabled", true);
				    	}
					}
			);
		}

		// Function to update the state and appearance of the bar graph
		function updateGraph(arr, current, swap, pass) {

			for (i = 1; i <= 10; i++) {
				// Update 
				elementID = "div.percentage" + i;
				percentage = arr[i-1] + "%"

				// Update 
				$(elementID).html(arr[i-1]);
				$(elementID).css("width", percentage);
				if (((i == current + 1) || (i == (current + 2))) && (current != -1)) {
					$(elementID).css("background-color", "red");
				} else {
					$(elementID).css("background-color", "black");
				}

	
			}

			$("#row1 td.infoindex").html(current+1);
			$("#row1 td.pass").html(pass);
			

		}

		
	</script>
	
</head>
<body onload="init()">
	
<h1>Bubble Sort Simulator</h1>
	
<table width=20% border=1>
	<tr id="row1">
		<td>Index: </td>
		<td class='infoindex'>0</td>
		<td>Pass #: </td>
		<td class='pass'>0</td>
	</tr>

</table>	

<br /><br />
	
	
	
<table width=100%>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage1">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage2">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage3">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage4">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage5">0</div>
		</div>
	</td>
  </tr>
  <tr>
  <td>
    	<div class="bar">
    		<div class="percentage6">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage7">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage8">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage9">0</div>
		</div>
	</td>
  </tr>
  <tr>
    <td>
    	<div class="bar">
    		<div class="percentage10">0</div>
		</div>
	</td>
  </tr>
</table>


<button type="button" id="btnStep" onclick="step()">Step</button>
<button type="button" id="btnShuffle"  onclick="shuff()">Shuffle</button>	

</body>
</html>


<?php } ?>

	
	
	
	
	
	
	








