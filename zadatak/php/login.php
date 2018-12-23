<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$username            = $dataJsonDecode->username;
$password            = $dataJsonDecode->password;

$sql = "SELECT * FROM user WHERE username='".$username."' AND password='".$password."'";
$return = $conn->query($sql);

if ($return->num_rows > 0) {
    $row = mysqli_fetch_array($return);

    $result = array('code' => 0,
        'sessionKey' => "session".$row['id'],
        'id' => $row['id'],
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'role' => $row['role']);

    $sql2 = "INSERT INTO user_session (userId, sessionKey) VALUES (".$row['id'].",'session".$row['id']."')";
    $return2 = $conn->query($sql2);

    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "User not found!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>
