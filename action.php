<?php

session_start();
include 'config.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $photo=$_FILES['image']['name'];
    $upload="uploads/".$photo;

    $query="INSERT INTO crud(name,email,phone,photo)VALUES(?,?,?,?)";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("ssss",$name,$email,$phone,$upload);
    $stmt->execute();
    move_uploaded_file($_FILES['image']['tmp_name'], $upload);

    header('location:index.php');

    $_SESSION['response']="Successfully Inserted to the database! ";
    $_SESSION['res_type']="success";

    if(isset($_GET['delete'])){
		$id=$_GET['delete'];

		$sql="SELECT photo FROM crud WHERE id=?";
		$stmt2=$conn->prepare($sql);
		$stmt2->bind_param("i",$id);
		$stmt2->execute();
		$result2=$stmt2->get_result();
		$row=$result2->fetch_assoc();

		$imagepath=$row['photo'];
		unlink($imagepath);

		$query="DELETE FROM crud WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();

		header('location:index.php');
		$_SESSION['response']="Successfully Deleted!";
		$_SESSION['res_type']="danger";
	}
}
?>