<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$illnessId          = $dataJsonDecode->illnessId;
$customerId         = $dataJsonDecode->customerId;
$comment            = $dataJsonDecode->comment;
$date = date("d.m.Y");

$sql = "INSERT INTO illness_customer (illnessId,customerId,comment,arrivalDate) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $illnessId, $customerId,$comment,$date);
$return = $stmt->execute();

if($return){
    $result = array('code' => 0, 'msg' => "Illness added!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Illness not added!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close(); Pdf:
}

?>