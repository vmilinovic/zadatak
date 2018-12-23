<?php include 'connection.php';?>

<?php

    $data               = file_get_contents("php://input");
    $dataJsonDecode     = json_decode($data, true);
    $customer            = $dataJsonDecode['customer'];
    $sql = "INSERT INTO customer (firstname,lastname,street,streetNumber,zipCode,phone,birthDate,userId,img,pdf,word) VALUES('"
        .$customer['firstname']."','"
        .$customer['lastname']."','"
        .$customer['street']."','"
        .$customer['streetNumber']."','"
        .$customer['zipCode']."','"
        .$customer['phone']."','"
        .$customer['birthDate']."','"
        .$customer['userId']."','"
        .$customer['img']."','"
        .$customer['pdf']."','"
        .$customer['word']."');";

    $return = $conn->query($sql);

    if($return){
        $result = array('code' => 0, 'msg' => "Patient created!");
        header('Content-Type: application/json');
        echo json_encode(array('result'=>$result));
        $conn->close();
    } else {
        $result = array('code' => 9999, 'msg' => "Patient not created!");
        header('Content-Type: application/json');
        echo json_encode(array('result'=>$result));
        $conn->close();
    }

?>