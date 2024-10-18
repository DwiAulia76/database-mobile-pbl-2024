<?php 

include("dbconection.php");
$con=dbconection();


if(isset($_POST["username"]))
{ 
    $username=$_POST["username"]; 
}
else return;
if(isset($_POST["password"]))
{ 
    $password=$_POST["password"]; 
}
else return;
if(isset($_POST["nama"]))
{ 
    $nama=$_POST["nama"]; 
}
else return;
if(isset($_POST["nis"]))
{ 
    $nis=$_POST["nis"]; 
}
else return;
if(isset($_POST["nuptk"]))
{ 
    $nuptk=$_POST["nuptk"]; 
}
else return;
if(isset($_POST["jenis_kelamin"]))
{ 
    $jeniskelamin=$_POST["jenis_kelamin"]; }
else return;
if(isset($_POST["role_id"]))
{ 
    $roleid=$_POST["role_id"]; 
}
else return;

$query="INSERT INTO `user`(`username`, `password`, `nama`, `nis`, `nuptk`, `email`, `jenis_kelamin`, `role_id`) 
VALUES ('$username','$password','$nama','$nis','$nuptk','$email','$jeniskelamin','$roleid')";
$exe=mysqli_query($con,$query);

$arr=[];
if($exe)
{
    $arr["success"]="true";
}
else
{
    $arr["success"]="false";
}
print((json_encode($arr)));

?>