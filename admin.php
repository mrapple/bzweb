<?php
/*
    BZWeb v1.0
    Copyright (c) 2010 Tony Bruess

	BZWeb is an online based tool developed by mrapple which allows multiple users to manage bzfs instances.
	For questions, join ##bzbureau on irc.freenode.net and ask mrapple.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this program.  If not, see
    <http://www.gnu.org/licenses/>.
*/
	session_start(); 
	header("Cache-control: private");
	$page = $_SERVER['PHP_SELF'];
	include_once("include/session.php");
	include_once("include/header.php");
	include_once("include/menu.php");
if($_SESSION['callsign']!=='mrapple'){
} else {
	?>
<h3>Admin CP</h3>
<?php
if(!$_GET['op']){
	echo "Please select an option below<br><br>";
}?>
<fieldset>
<legend><a href="?op=config">Site Configuration</a></legend>
<?php if($_GET['op']=='config'){
		$set_data = mysql_fetch_array(mysql_query("SELECT * FROM settings"));
		echo $err;
?>
<form method="post">
Site Name: <input type="text" name="site" value="<?php echo $set_data[0]?>">
<br>
Admin Email: <input type="text" name="email" value="<?php echo $set_data[1]?>">
<br>
BZFS Executable: <input type="text" name="bzfs" value="<?php echo $set_data[2]?>">
<br>
Domain: <input type="text" name="domain1" value="<?php echo $set_data[3]?>">
<br>
<input type="hidden" name="updatesettings" value="1">
<input type="submit" value="Save">
</form>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?op=roles">Permission Roles</a></legend>
<?php if($_GET['op']=='roles' && !$_GET['mode']){
	if($_POST['deleterole']){
	mysql_query("DELETE FROM roles WHERE id=".$_POST['deleterole']);
	}
	if($_POST['newrole']){
	$newrole = "INSERT INTO roles (`name`) VALUES ('".$_POST['newrole']."')";
	mysql_query($newrole);
	echo mysql_error();
	}
	$q = mysql_query("SELECT * FROM roles");
?>
			<table cellpadding=5>
				<tr>
				  <th width="50%">Name</th>
				  <th width="20%">Edit</th>
				  <th width="20%">Delete</th>
				 </tr>
				 <?php while($roles = mysql_fetch_array($q)){ ?>
				 <tr class="a" bgcolor=#CCCCCC>
					<td><?php echo $roles['name']?></td>
				 	<td><a href="admin.php?op=group&mode=edit&role=<?php echo $roles['id'] ?>">Edit</a></td>
				 	<td><form method="post">
					<input type="submit" value="Delete">
					<input type="hidden" name="deleterole" value="<?php echo $roles['id']?>" >
					</form></td>
				 </tr>
				 <?php
				 }
				 ?>
			</table>
			<form method=post>
			New Role:
			<input type=text name=newrole>
			<input type=submit value=Create>
			</form>
<?php			
}
if($_GET['mode']=='edit'){
	if($_REQUEST['save']){
	$_POST[0] = 9;
	if(!$_POST[1]) $_POST[1] = 0;
	if(!$_POST[2]) $_POST[2] = 0;
	if(!$_POST[3]) $_POST[3] = 0;
	if(!$_POST[4]) $_POST[4] = 0;
	if(!$_POST[5]) $_POST[5] = 0;
	if(!$_POST[6]) $_POST[6] = 0;
	if(!$_POST[7]) $_POST[7] = 0;
	if(!$_POST[8]) $_POST[8] = 0;
	if(!$_POST[9]) $_POST[9] = 0;
	if(!$_POST[10]) $_POST[10] = 0;
	if(!$_POST[11]) $_POST[11] = 0;
	if(!$_POST[12]) $_POST[12] = 0;
	if(!$_POST[13]) $_POST[13] = 0;
	if(!$_POST[14]) $_POST[14] = 0;
	if(!$_POST[15]) $_POST[15] = 0;
	if(!$_POST[16]) $_POST[16] = 0;
	if(!$_POST[17]) $_POST[17] = 0;
	if(!$_POST[18]) $_POST[18] = 0;
	$perm = $_POST[0].$_POST[1].$_POST[2].$_POST[3].$_POST[4].$_POST[5].$_POST[6].$_POST[7].$_POST[8].$_POST[9].$_POST[10].$_POST[11].$_POST[12].$_POST[13].$_POST[14].$_POST[15].$_POST[16].$_POST[17].$_POST[18];
	echo $perm;
		mysql_query("UPDATE roles SET permissions='$perm' WHERE id=".$_GET['role']."");
	}
$roles = mysql_fetch_array(mysql_query("SELECT * FROM roles WHERE id=".$_GET['role'].""));
$perm = str_split($roles['permissions']);
?>
<form method="post">
<table width="100%" cellpadding=5>
				 <tr>
				  <th>User/Admin</th>
				  <th>Servers</th>
				  <th>Groups</th>
				  <th>Files</th>
				  <th>Global</th>
				  <th>Per User</th>
				 </tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="18" type="checkbox" value="1"<?php if($perm[18]=='1') echo ' checked'?>> Login</td>
<td><input name="2"  type="checkbox" value="1"<?php if($perm[2]=='1') echo ' checked'?>> Create Servers</td>
<td><input name="5"  type="checkbox" value="1"<?php if($perm[5]=='1') echo ' checked'?>> Create Groups</td>
<td><input name="8"  type="checkbox" value="1"<?php if($perm[8]=='1') echo ' checked'?>> Create Files</td>
<td><input name="9"  type="checkbox" value="1"<?php if($perm[9]=='1') echo ' checked'?>> Ban</td>
<td><input name="10"  type="checkbox" value="1"<?php if($perm[10]=='1') echo ' checked'?>> Ban on their servers</td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><input name="1"  type="checkbox" value="1"<?php if($perm[1]=='1') echo ' checked'?>> Admin CP</td>
<td><input name="3"  type="checkbox" value="1"<?php if($perm[3]=='1') echo ' checked'?>> Delete Servers</td>
<td><input name="6"  type="checkbox" value="1"<?php if($perm[6]=='1') echo ' checked'?>> Delete Groups</td>
<td><input name="17"  type="checkbox" value="1"<?php if($perm[17]=='1') echo ' checked'?>> Delete Files</td>
<td><input name="11"  type="checkbox" value="1"<?php if($perm[11]=='1') echo ' checked'?>>Player Info</td>
<td><input name="12"  type="checkbox" value="1"<?php if($perm[12]=='1') echo ' checked'?>> Player Info for their servers</td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><center>--</center></td>
<td><input name="4"  type="checkbox" value="1"<?php if($perm[4]=='1') echo ' checked'?>> Delete their servers</td>
<td><input name="7"  type="checkbox" value="1"<?php if($perm[7]=='1') echo ' checked'?>> Delete their groups</td>
<td><center>--</center></td>
<td><input name="13"  type="checkbox" value="1"<?php if($perm[13]=='1') echo ' checked'?>> Reports</td>
<td><input name="14"  type="checkbox" value="1"<?php if($perm[14]=='1') echo ' checked'?>> Reports for their servers</td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><center>--</center></td>
<td><center>--</center></td>
<td><center>--</center></td>
<td><center>--</center></td>
<td><input name="15"  type="checkbox" value="1"<?php if($perm[15]=='1') echo ' checked'?>> Logs</td>
<td><input name="16"  type="checkbox" value="1"<?php if($perm[16]=='1') echo ' checked'?>> Logs for their servers</td>
</tr>
</table>
<input type="hidden" name="save" value="1">
<input type="submit" value="Save">
</form>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?op=users">Users</a></legend>
<?php if($_GET['op']=='users'){
?>
<table cellpadding=5>
<th>User</th>
<th>Role</th>
<th>Last Login</th>
<?php
if($_POST['role']){
	mysql_query("UPDATE users SET `permissions`=".$_POST['role']." WHERE id=".$_POST['id']);
}
if($_POST['newuser']){
	$userm = mysql_query("SELECT * FROM users WHERE name='".$_POST['newuser']."'");
	$q = mysql_fetch_array($userm);
	if($q[0]){
		echo "User exists";
	} else {
	$ts = time();
	mysql_query("INSERT INTO users (`name`,`permissions`,`last login`) VALUES ('".$_POST['newuser']."','".$_POST['role']."','$ts')");
	echo mysql_error();
	}
}
$q = mysql_query("SELECT * FROM users");
while($users = mysql_fetch_array($q)){
?>
<tr class="a" bgcolor=#CCCCCC>
<td><?php echo $users['name']?></td>
<td>
<form method="post">
<select name= "role" onchange="this.form.submit();">
<option></option><?php
$roleq = mysql_query("SELECT * FROM roles");
while($role = mysql_fetch_array($roleq)){
	?>
	<option value="<?php echo $role['id'] ?>" <?php if($role['id'] == $users['permissions']) echo 'selected'?>><?php echo $role['name'] ?></option>
<?php
}
?>
	<input type="hidden" name="id" value="<?php echo $users['id']?>">
</form>
</td>
<td><?php echo date("Y-m-d",$users['last login']).' '.date("h:i:s A",$users['last login']);?></td>
</tr>
<?php
}
?>
</table>
<br>
<form method=post>
Callsign: <input type=text name=newuser>
<br>
Role: <select name="role">
<?php
$q2 = mysql_query("SELECT * FROM roles");
while($role = mysql_fetch_array($q2)){
	?>
	<option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
<?php
}
?>
</select>
<br>
<input type="submit" value="Add User">
</form>
<?php
}
?>
</fieldset>
<?php
}
include_once("include/footer.php");

?>