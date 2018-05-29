<!DOCTYPE html>
<html>
<head>
	<title>ATM</title>
</head>
<body>

Welcome:
<br>
<?php 
	ini_set("display_errors",1);
	include_once "Money.php";

	if(isset($_GET['notes'])){
		include_once "Withdraw.php";
		$withdraw = new Withdraw('atm', '127.0.0.1', 'root', '');

		$request = !empty($_GET['notes']) ? $_GET['notes'] : 0;
		if ($request && $request <= $withdraw->getTotalAmount()) {
			$withdraw->withdrawMoney($request);
		}
		else {
			$res = $withdraw->select("SELECT money_type, amount FROM bank");
			$money = [];
			foreach ($res as $item) {
				$money[$item['money_type']] = $item['amount'];
			}
		}
	}

	$money = new Money('atm', '127.0.0.1', 'root', '');
	if (!$money->getTotalAmount()) {
		print 'Sorry the ATM is out of money';
		
	}else{
		echo 'Available Money: $'.$money->getTotalAmount();
	}

	if(isset($_GET['notes'])){
		echo "<br>";
		foreach ($withdraw->getAmounts() as $key => $value) {
			echo "Remaining $" . $value['money_type']. "s:  ". $value['amount']."<br>";
		}
	}
	
?>
<br><br>
<form action="view.php" method="GET">
	<input id="notes" type="number" name="notes" placeholder="Amount to withdraw">
	<br>
	<button id="withdraw">Withdraw</button>
</form>
</body>
</html>