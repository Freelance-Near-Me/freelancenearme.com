<?php
	//My SQL class 
	class mysql{
		var $h="";
		var $u="";
		var $p="";
		var $d="";
		var $Er="";
		var $con="";
		
		function mysql($host,$user,$pass,$db=""){
			$h=$host;
			$u=$user;
			$p=$pass;
			$con = mysqli_connect($h, $u, $p,$db);
			if(! $con){
				$Er=mysqli_error();
				die("Sorry ! Can't connect to MySQL server. ") ;
			}	
			if($db != ""){
				return $con;
			}		
		}
		function selDB($db){
			mysqli_select_db($db);
		}
		function convart_array($con,$v){
			$r[]= array();
			$i=0;
			while($rt=mysqli_fetch_array($v)){
				$r[$i]=$rt;
				$i++;
			}
			return $r;
		}
		function select($con,$q){
			$r=mysqli_query($con,$q);
			return $this->convart_array($con,$r);
		}
		function select_array($con,$q){
			$r=mysqli_query($con,$q);
			return mysqli_fetch_array($r);
		}
			
		function run($con,$q){
			if(mysqli_query($con,$q)){
				return true;
			}else{
				return false;
			}
		}
		function test($con,$v){
			$r=mysqli_query($con,$v);
			return $r;
		}
		
	}
?>