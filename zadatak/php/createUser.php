<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$username           = $dataJsonDecode->username;
$password           = $dataJsonDecode->password;
$firstname          = $dataJsonDecode->firstname;
$lastname           = $dataJsonDecode->lastname;
$role               = $dataJsonDecode->role;

$sql = "INSERT INTO user (username, password, firstname, lastname, role) VALUES (?,?,?,?,?);";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssssi", $username, $password, $firstname, $lastname, $role);
    $stmt->execute();
    $result = array('code' => 0, 'msg' => "User created!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "User not created!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>