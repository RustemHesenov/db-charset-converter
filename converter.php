<?php
error_reporting(E_ALL);
$dbname = "yourdbname";
mysql_connect("localhost", "root", "root") or die(mysql_error());
mysql_select_db("$dbname");
mysql_query("SET NAMES 'utf8';") or die(mysql_error());

$query = "SHOW TABLES";
$result = mysql_query($query) or die(mysql_error());
while ($data = mysql_fetch_assoc($result)) {

	$table = $data["Tables_in_$dbname"];
	$query = "alter table $table convert to character set utf8 collate utf8_turkish_ci";
	mysql_query($query) or die(mysql_error());
	echo "<b>$table</b><br>";

	$query = "SHOW COLUMNS FROM $table";
	$result_2 = mysql_query($query) or die(mysql_error());
	while ($columns = mysql_fetch_assoc($result_2)) {

		if (
				(stripos($columns['Type'], 'varchar')!==false)
				||
				(stripos($columns['Type'], 'text')!==false)
		) {
			$query = "ALTER TABLE $table MODIFY {$columns['Field']} {$columns['Type']} CHARACTER SET utf8 COLLATE utf8_turkish_ci";
			mysql_query($query) or die(mysql_error());
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$columns['Field']}<br>";
		}
	}
}

echo "<hr><h1>Done!</h1>";
