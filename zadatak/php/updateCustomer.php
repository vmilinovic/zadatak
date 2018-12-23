<?php include 'connection.php';?>

<?php

$data               = file_get_contents("php://input");
$dataJsonDecode     = json_decode($data, true);
$customer            = $dataJsonDecode['customer'];

$sql = "UPDATE customer SET 
firstname='".$customer['firstname']."',
lastname='".$customer['lastname']."',
street='".$customer['street']."',
streetNumber='".$customer['streetNumber']."',
zipCode='".$customer['zipCode']."',
phone='".$customer['phone']."',
birthDate='".$customer['birthDate']."',
userId='".$customer['userId']."',
img='".$customer['img']."',
pdf='".$customer['pdf']."',
word='".$customer['word']."'
WHERE id='".$customer['id']."';";

$return = $conn->query($sql);

if($return){
    $result = array('code' => 0, 'msg' => "Patient updated!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
} else {
    $result = array('code' => 9999, 'msg' => "Patient not updated!");
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$result));
    $conn->close();
}

?>