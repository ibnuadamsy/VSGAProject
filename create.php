<?php

if(isset($_POST['submit'])){

    // photo section
    if(isset($_FILES['photo'])){

	    // check the size of photo
	    $imageSize = $_FILES['photo']['size'];
	    if($imageSize > 102400){
		    echo "<script>alert('Image must be under 100kb')</script>";
		    echo "<a href='create.php'>Go back and try again</a>";
		    exit;
	    }
    	// check the photo type extension
    	$imageTypeValid = ['jpg', 'png', 'jpeg'];
    	$imageType = explode('.', $_FILES['photo']['name']);
    	$imageType = end($imageType);
    	$imageType = strtolower($imageType);
    	if(!in_array($imageType, $imageTypeValid)){
    		echo "<script>alert('Image must be jpg or png')</script>";
    		echo "<a href='create.php'>Go back and try again</a>";
    		exit;
    	}
    	// generate random name for photo
    	$imageName = uniqid(); 
    	$imageName = $imageName . '.' . $imageType;
    
    	// rename and move photo
    	$imageTemp = $_FILES['photo']['tmp_name'];
    	move_uploaded_file($imageTemp, 'image/' . $imageName);
    	$img = 'image/' . $imageName;
    }
    // end of photo section
    
    // variables
	$name = htmlspecialchars($_POST['name']);
	$age = $_POST['age'];
	$photo = $img;
	$sex = htmlspecialchars($_POST['sex']);
	$phone = htmlspecialchars($_POST['phone']);
	$majors = $_POST['majors'];
	
    // 	insert to database
	$db = mysqli_connect("localhost", "id15148377_root", "Cn*X@>0L*twkL5hx", "id15148377_raccoon_city_university");
	$insert = "INSERT INTO college_students (name, photo, age, sex, majors, phone) VALUES ('$name', '$photo', '$age', '$sex', '$majors', '$phone')";
	$query = mysqli_query($db, $insert);
	header("Location:read.php");
	
    // if theres an error
	if(mysqli_affected_rows($db) < 0){
	    echo "Failed to save data";
	    echo "<br>";
	    exit;
	   // if(isset(mysqli_error($db))){
	   //     echo mysqli_error($db);
	   //     exit;
	   // }
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Register as Student - University of Raccoon City</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
	<a class="navbar-brand" href="index.php">University of Raccoon City</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="create.php">Register</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="read.php">List of Students</a>
			</li>
			<?php if(isset($_SESSION['login'])) : ?>
			<li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			</li>
			<?php endif; ?>
			<?php if(!isset($_SESSION['login'])) : ?>
			<li class="nav-item">
				<a class="nav-link" href="login.php">Login</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</nav>
<div class="container">
	<div class="row">
		<h2 class="my-4 mx-auto">Register as Student</h2>
		    <?php if(isset($_POST['submit'])){
		            if(mysqli_affected_rows($db) < 0){
		                $error = mysqli_error($db);
		                echo '<small class="text-center"><?= $error;?></small>';
		            }
		    }?>
	<div class="offset-md-2 col-md-8">
		<p>Please fill the form below</p>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Your name" required>
			</div>
			<div class="form-group">
			    <label for="photo">Photo (File must be jpg/png and under 100kb)</label>
			    <input type="file" class="form-control-file" name="photo" required>
			</div>
			<div class="form-group">
			    <label for="age">Age</label>
			    <input type="number" class="form-control" id="age" name="age" min="12" max="100" placeholder="Your age" required>
			</div>
			<div class="mb-3">
				<label for="">Sex</label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="sex" id="sex" value="Male" required>
					<label class="form-check-label" for="sex">Male</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="sex" id="sex" value="Female">
					<label class="form-check-label" for="sex">Female</label>
				</div>
			</div>
			<div class="form-group">
				<label for="phone">Phone Number</label>
				<input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{12}" placeholder="Your phone number" maxlength="20" title="Number only 12 digits" required>
			</div>
			<div class="form-group">
			    <label for="majors">Majors</label>
			    <select class="form-control" id="majors" name="majors" required>
			    	<option value="Economics">Economics</option>
			    	<option value="Biology">Biology</option>
			    	<option value="Computer Science">Computer Science</option>
			    	<option value="English Language and Literature">English Language and Literature</option>
			    	<option value="Chemical Engineering">Chemical Engineering</option>
			    	<option value="Political Science">Political Science</option>
			    </select>
			</div>
			<div class="form-group">
				<button type="submit" name="submit" class="btn btn-success">Submit</button>
			</div>
		</form>
		<a href="read.php"><button class="btn btn-secondary mb-3">Cancel</button></a>
		</div>
	</div>
</div>

<script src="js/jquery-3.5.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>