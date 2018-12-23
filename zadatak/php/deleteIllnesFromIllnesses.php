<?php include 'connection.php';?>

<?php

$data                      = file_get_contents("php://input");
$dataJsonDecode            = json_decode($data);
$id                        = $dataJsonDecode->id;

$sql = "DELETE FROM illness WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$return = $stmt->execute();
$stmt->close();

if($return){
    $result = array('code' => 0, 'msg' => "Illness deleted!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Illness not deleted!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>