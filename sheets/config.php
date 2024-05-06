<?php 
// Setting the timezone
   $tz = 'Asia/Kolkata';   
   date_default_timezone_set($tz);

//database Name
    $database = "orange-leaf";
//connect to database
	//$con = mysqli_connect("localhost","root","",$database); 
	$con = mysqli_connect("localhost","orangeDB","#V2wq016x",$database); 

		if(mysqli_connect_errno()){
			echo "Failed to connect Mysql:" . mysqli_connect_errno();
		}

		$tb_journal="trade_journal";
		$tb_summary="trade_summary";
		$tb_expense="expense";
?>