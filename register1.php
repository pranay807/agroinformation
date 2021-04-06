
<?php
echo "<link rel='stylesheet' href='main.css'>";
$password='';
$repeatpassword='';


    $mysqli = new mysqli("localhost","root","","agriculture");
    $email=$_POST["email"];
    $password=$_POST["password"];
    $repeatpassword=$_POST["repeatpassword"];


$mysqli = new mysqli("localhost","root","","agriculture");   

$query1 = "INSERT INTO farmer(email,password,repeatpassword) VALUES ('$email','$password','$repeatpassword')";

$result1 = $mysqli->query($query1);


$query2 = "SELECT * FROM farmer";
$result2 = $mysqli -> query($query2);

echo "<h2>Registered Farmer</h2>";
echo "<table>";
echo "<tr>";
echo "<th>email</th>";
echo "<th>password</th>";
echo "<th>repeatpassword</th>";
echo "</tr>";

while($row2 = $result2 -> fetch_assoc()){
    echo "<tr>";
    echo "<th>".$row2["email"]."</th>";
    echo "<th>".$row2["password"]."</th>";
    echo "<th>".$row2["repeatpassword"]."</th>";
    echo "</tr>";
}
echo "</table>";

?>