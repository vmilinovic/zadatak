<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$id                 = $dataJsonDecode->id;

$sql = "DELETE FROM customer WHERE id='".$id."';";
$return = $conn->query($sql);

if($return){
    $result = array('code' => 0, 'msg' => "Patient deleted!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Patient not deleted!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>