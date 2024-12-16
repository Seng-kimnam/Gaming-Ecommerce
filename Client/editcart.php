<?php
$index = $_GET["index"];
$oper = $_GET["oper"];
session_start();
$cart = $_SESSION['cart'];
//'-' Operator 
if ($oper == 'sub' ) {
    if($cart[$index][3] > 1){
        $cart[$index][3] -=1;
    }
    else{
        unset($cart[$index]);
    }
}

//'+' Operator 
if ($oper == 'sum') {
    $cart[$index][3] += 1;
}
$_SESSION['cart'] =  $cart;
header("Location:listcart.php");
