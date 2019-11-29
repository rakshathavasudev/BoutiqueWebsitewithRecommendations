<?php 
	require("includes/common.php");

	#getting data entered in signup and cleaning data submitted by the user
   if (isset($_POST['name'])){ 
   	$name=$_POST['name'];
  	$name = mysqli_real_escape_string($con, $name);
  }

   if(isset($_POST['email'])){
   $email= $_POST['email'];
  $email = mysqli_real_escape_string($con, $email);}

   if(isset($_POST['password'])){ 
   	$password=$_POST['password'];
  $password = mysqli_real_escape_string($con, $password);
  $password = MD5($password);}

   if(isset($_POST['contact'])){ 
   	$contact=$_POST['contact'];
  $contact = mysqli_real_escape_string($con, $contact);}

   if(isset($_POST['city'])){ 
   	$city=$_POST['city'];
  $city = mysqli_real_escape_string($con, $city);}

  if(isset($_POST['address'])){
  $address= $_POST['address'];
  $address = mysqli_real_escape_string($con, $address);}

  #backend validations
  $regex_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
  $regex_num = "/^[789][0-9]{9}$/";

  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($con, $query)or die($mysqli_error($con));
  $num = mysqli_num_rows($result);

  if ($num != 0) {
    $m = "<span class='red'>Email Already Exists</span>";
    header('location: signup.php?m1=' . $m);
  } else if (!preg_match($regex_email, $email)) {
    $m = "<span class='red'>Not a valid Email Id</span>";
    header('location: signup.php?m1=' . $m);
  } else if (!preg_match($regex_num, $contact)) {
    $m = "<span class='red'>Not a valid phone number</span>";
    header('location: signup.php?m2=' . $m);
  } else {
    
    $query = "INSERT INTO users(name, email, password, contact, city, address)VALUES('" . $name . "','" . $email . "','" . $password . "','" . $contact . "','" . $city . "','" . $address . "')";
    mysqli_query($con, $query) or die(mysqli_error($con));
    $user_id = mysqli_insert_id($con);
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $user_id;
    header('location: product.php');
  }
?>