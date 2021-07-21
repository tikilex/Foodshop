<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "foodshop";

function connect(){
    $conn = mysqli_connect("localhost", "root", "root", "foodshop");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function init(){
    //вывожу список товаров
    $conn = connect();
    $sql = "SELECT id, name FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $out = array();
        while($row = mysqli_fetch_assoc($result)) {
            $out[$row["id"]] = $row;
        }
        echo json_encode($out);
    } else {
        echo "0";
    }
    mysqli_close($conn);
}
function selectOneGoods(){
    $conn = connect();
    $id = $_POST ['gid'];
    $sql = "SELECT * FROM goods WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo "0";
    }
    mysqli_close($conn);
}
function updateGoods()
    {
        $conn = connect();
        $id = $_POST['id'];
        $name = $_POST['gname'];
        $cost = $_POST['gcost'];
        $description = $_POST['gdescription'];
        $image = $_POST['gimage'];

        $sql = "UPDATE goods SET name = '$name', cost = '$cost', description = '$description', image = '$image'  WHERE id ='$id' ";

            if (mysqli_query($conn, $sql)) {
                echo 1;
                } else {
                        echo "Error updating record: " . mysqli_error($conn);
                        }

        mysqli_close($conn);
        writeJSON();
    }
    function newGoods()
    {
        $conn = connect();
        $name = $_POST['gname'];
        $cost = $_POST['gcost'];
        $description = $_POST['gdescription'];
        $image = $_POST['gimage'];

       $sql = "INSERT INTO goods (name, cost, description, image) VALUES ('$name', '$cost', '$description', '$image' )";

        if (mysqli_query($conn, $sql)) {
            echo "1";
        }
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
        writeJSON();
    }
    function writeJSON(){
        $conn = connect();
        $sql = "SELECT * FROM goods";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $out = array();
            while($row = mysqli_fetch_assoc($result)) {
                $out[$row["id"]] = $row;
            }
             $a = file_put_contents ('../goods.json', json_encode($out));
             echo $a;
        } else {
            echo "0";
        }
        mysqli_close($conn);
    
        }