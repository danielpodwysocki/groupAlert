<?php
require "dblogin.php";
$dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
$res=$dbh->query("SELECT groupID FROM AlertToGroup WHERE alertID=2");

print_r($res->fetchAll());