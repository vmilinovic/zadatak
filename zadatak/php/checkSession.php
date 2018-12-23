<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$sessionKey         = $dataJsonDecode->sessionKey;
$userId             = $dataJsonDecode->userId;

$sql = "SELECT * FROM user_session WHERE sessionKey='".$sessionKey."' AND userId='".$userId."'";
$return = $conn->query($sql);

if ($return->num_rows > 0) {
    $result = array('code' => 0, 'msg' => "User session founded!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "User session not founded!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}
