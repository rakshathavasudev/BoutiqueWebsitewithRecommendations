<?php 
	require("includes/common.php");

	if (isset($_POST['name'])){ 
   	$name=$_POST['name'];
  	$name = mysqli_real_escape_string($con, $name);
  }

  if(isset($_POST['contact'])){ 
   	$contact=$_POST['contact'];
  $contact = mysqli_real_escape_string($con, $contact);}

   if(isset($_POST['shoulder'])){
   $shoulder= $_POST['shoulder'];
  $shoulder = mysqli_real_escape_string($con, $shoulder);}

   if(isset($_POST['waist'])){ 
   	$waist=$_POST['waist'];
  $waist = mysqli_real_escape_string($con, $waist);
  }
  if(isset($_POST['chest'])){ 
   	$chest=$_POST['chest'];
  $chest = mysqli_real_escape_string($con, $chest);
  }
   $regex_num = "/^[789][0-9]{9}$/";

   $query = "SELECT * FROM newusers WHERE Name='$name'";
  	$result = mysqli_query($con, $query)or die($mysqli_error($con));
  	$num = mysqli_num_rows($result);

  	if ($num != 0) {
    $m = "<span class='red'>Email Already Exists</span>";
    header('location: select.php?m1=' . $m);

  } else if (!preg_match($regex_num, $contact)) {
    $m = "<span class='red'>Not a valid phone number</span>";
    header('location: newuser.php?m2=' . $m);
  } else {
    
    $query = "INSERT INTO newusers(name, contact, shoulder,waist,chest )VALUES('" . $name . "','" . $contact . "','" . $shoulder . "','" . $waist . "','" . $chest . "')";
    mysqli_query($con, $query) or die(mysqli_error($con));
    $user_id = mysqli_insert_id($con);
    
   echo "<script type='text/javascript'>alert('Submitted successfully!')</script>";
   header('Location:select.php');
  }
?>