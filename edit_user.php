<?php include('auth.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <title>Details User</title>
 </head>
 <?php include('db_connection.php'); ?>
 <?php include('menu.php'); ?>
 <h2>User</h2>
 <?php echo "<form action='edit_user_save.php?user_idnr=".$_GET['user_idnr']."' method='post'>"; ?>
	<table border='0'>
		
 <?php
 // SQL-Query
	$sql = "SELECT * FROM dbmail_users WHERE user_idnr=".$_GET['user_idnr'];
	// ausf�hren der Query
	$db_erg = mysql_query( $sql );
	if ( ! $db_erg ){
		die('Ung�ltige Abfrage: ' . mysql_error());
	}
	while ($daten = mysql_fetch_array( $db_erg, MYSQL_ASSOC))
	{
    // Aushabe der Daten
	$mbox_cur_mb = round($daten['curmail_size'] / 1048576, 2);
	$mbox_max_mb = round($daten['maxmail_size'] / 1048576, 2);
	
    echo "<tr> <th>user_idnr</th> <td id='user_idnr'>".$daten['user_idnr']."</td> </tr>";
	echo "<tr> <th>Name</th> <td><input name='name' type='text' value='".$daten['name']."' size='30'> </td> </tr>";
	echo "<tr> <th>User ID</th> <td><input name='userid' type='text' value='".$daten['userid']."' size='30'></td> </tr>";
	echo "<tr> <th>Password</th> <td><input name='passwd' type='text' value='".$daten['passwd']."' size='30'></td> <td>Type: <select name='encryption_type'><option>".$daten['encryption_type']."</option><option></option><option>md5</option></select></td> </tr>"; 
	echo "<tr> <th>Mailbox size</th> <td>".$mbox_cur_mb." MB / <input name='maxmail_size' type='text' value='".$mbox_max_mb."' size='10'> MB</td> <td></td><td><i>0 means unlimited space.</i></td> </tr>";
	echo "<tr> <th>Last Login</th> <td>".$daten['last_login']."</td> </tr>";
	}

?>
	</table>
	<p>
	<input type="submit" value="Send">
    <input type="reset" value="Cancel">
    </p>
	</form>
		
	<!-- DBMail aliases gruppiert nach deliver_to -->
	
	<h2>Aliases</h2>
	<script type="text/javascript">
	function loadAliases()
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("aliases").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","list_aliases.php?user_idnr=" + document.getElementById('user_idnr').innerHTML,true);
		xmlhttp.send();
	}
	
	loadAliases();
	
	</script>
	<script type="text/javascript">
	function saveAlias()
	{
		var params = "deliver_to=" + document.getElementById('user_idnr').innerHTML + "&alias=" + document.forms.new_alias.alias.value;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("saveAliasesResponse").innerHTML=xmlhttp.responseText;
				loadAliases();
			}
		}
		xmlhttp.open("POST","new_forward_save.php",true);
		//Send the proper header information along with the request
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", params.length);
		xmlhttp.setRequestHeader("Connection", "close");
		xmlhttp.send(params);
	}
	</script>
	<!-- AJAX-Script for deleting a Alias -->
	<script type="text/javascript">
	function delAlias(alias_idnr)
	{
		Check = confirm("Delete that alias? Alias=" + alias_idnr);
		if (Check == true){
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("saveAliasesResponse").innerHTML=xmlhttp.responseText;
					loadAliases();
				}
			}
			xmlhttp.open("GET","del_forward.php?alias_idnr=" + alias_idnr,true);
			xmlhttp.send();
		}
	}
	</script>
	
	
	<div id='aliases'></div>
	<div id='saveAliasesResponse'></div>
	<form id='new_alias' action='' method='post'>
	<table>
		<tr><td></td><td><input type='text' name='alias' size='30'></td><td><input type='button' value='Add' onClick='saveAlias()'></td></tr>
	</table>
	</form>
	
	
	<!-- AJAX-Script for deleting a Alias -->
	<script type="text/javascript">
	function delUser()
	{
		Check = confirm("Delete that User? user_idnr=" + document.getElementById('user_idnr').innerHTML);
		if (Check == true){
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					alert('User deleted!');
					window.location.href='index.php';
				}
			}
			xmlhttp.open("GET","del_user.php?user_idnr=" + document.getElementById('user_idnr').innerHTML,true);
			xmlhttp.send();
		}
	}
	</script>
	
	<p><a href='javascript:delUser()'>Delete User</a> <i>At the moment only the entry in the user-table will be deleted! All other data like mails ect. will stay like a zombie!</i></p>
</html>
 