<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data);
$name          = $dataJsonDecode->name;
$description         = $dataJsonDecode->description;

$sql = "INSERT INTO illness (name,description) VALUES (?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $description);
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
    $conn->close();
}

?>