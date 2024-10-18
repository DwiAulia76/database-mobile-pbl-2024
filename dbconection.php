<?php

function dbconection()
{
    $con=mysqli_connect("localhost","root","","if31");
    return $con;
}

?>