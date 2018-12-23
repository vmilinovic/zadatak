<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$illnessId                 = $dataJsonDecode->illnessId;
$customerId                = $dataJsonDecode->customerId;

$sql = "DELETE FROM illness_customer WHERE illnessId=? AND customerId=?";
$stmt = $conn->prepare($sql);
$return = $stmt->bind_param($sql, $illnessId, $customerId);

if($return){
    $result = array('code' => 0, 'msg' => "illness deleted!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Customer not deleted!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>