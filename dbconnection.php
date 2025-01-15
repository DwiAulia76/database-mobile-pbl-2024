<?php 

function dbconnection()
{
    $con=mysqli_connect("localhost","root", "","if31");
    return $con;
}

?>