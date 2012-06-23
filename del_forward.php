<?php include('auth.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <title>Delete Forward</title>
 </head>
<body>
 <?php include('db_connection.php'); ?>

 <?php 
 try {
 	$STH = $DBH->prepare("DELETE FROM dbmail_aliases WHERE alias_idnr= :alias_idnr");
 	$STH->bindParam(':alias_idnr', $_GET['alias_idnr']);
	// execute query
	$STH->execute();
	echo "Forward/Alias deleted!";
 } catch (PDOException $e){
	echo "Can not do that: " + $e->getMessage();
 }

?>

</body>
</html>