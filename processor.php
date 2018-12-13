<?php

include('connect.php');
$a = $_POST['stocktype'];
$b = $_POST['qty'];
$c = $_POST['date'];
$d = $_POST['time'];
// query
$sql = "INSERT INTO stocktable (Stocktype,Qty,StockDate,TimeOfDay) VALUES (:a,:b,:c,:d)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d));
header("location: index.html");
?>