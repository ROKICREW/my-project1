<?php
$Name = $_POST['Name']
$Phone = $_POST['Phone']
$Mail = $_POST['Mail']
$Events = $_POST['Events']
$Location = $_POST['Location']
$Date = $_POST['Date']
$Time = $_POST['Time']

//Database connection
$conn = new mysqli('localhost','root','','test');
if($conn->connect_error){
    die('connection failer:',$conn->connect_error);
}else{
    $stmt=$conn->prepare("insert into booking(Name,Phone,Mail,Events,Location,Date,Time)values(?,?,?,?,?,?,?)");
    $stmt->blind_param("s,i,s,s,s,i,i",$Name,$Phone,$Mail,$Events,$Location,$Date,$Time);
    $stmt->execute();
    echo "Booking Successfully...!!!";
    $stmt->close();
    $stmt->close();
}
?>