<?php
#<============================== Connection ==============================>#
$con = mysqli_connect("localhost","root","","database1");


#<============================== Sign Up ==============================>#
if(isset($_POST['submitsignup'])) {
	if ($_POST['confirmpassword'] === $_POST['password']) {
		$Username = $_POST['username'];
		$Password = $_POST['password'];
		$Email = $_POST['email'];
		$sql = "INSERT INTO users (username, password, email) VALUES('$Username', '$Password', '$Email')";
		if (mysqli_query($con, $sql)) {
			echo "<script>alert('Account Successfully Created Please Login.'); window.location.href = 'login.html';</script>";
		}
		else {
			echo "<script>alert('Username already exists !'); window.location.href = 'index.html';</script>";
		}
	}
	else {
		echo "<script>alert('Password does not match'); window.location.href = 'index.html';</script>";
	}
}


#<============================== Login ==============================>#
if(isset($_POST['submitlogin'])) {
	
	$Username=$_POST['username'];
	$Password=$_POST['password'];
	$Username = stripcslashes($Username);  
	$Password = stripcslashes($Password);  
	$Username = mysqli_real_escape_string($con, $Username);  
	$Password = mysqli_real_escape_string($con, $Password);  

	$sql = "SELECT * FROM users WHERE username='$Username' AND password='$Password'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
	$count = mysqli_num_rows($result);

	if($count == 1){
		session_start();
		$_SESSION['login_user']=$Username;
		header("Location: welcome.html");
	}  
	else{  
		echo "<script>alert('Wrong username or Password.'); window.location.href = 'login.html';</script>";
	}
}


#<============================== Logout ==============================>#
if(isset($_POST['submitlogout'])) {
	session_start();
	if(isset($_SESSION['login_user']) ){
		session_destroy();
		header("location: index.html");
		exit();
	}
	else {
		header("location: index.html");
		// echo "<script>alert('You are not authorized to view this page.'); window.location.href = 'login.html';</script>";
	}
}


#<============================== Insert ==============================>#
if(isset($_POST['submitinsert'])) {
	if (!isset($_SESSION["login_user"])) {
		$Firstname = $_POST['firstname'];
		$Lastname = $_POST['lastname'];
		$Number = $_POST['number'];
		$Address = $_POST['address'];
		$sql = "INSERT INTO customer (firstname, lastname, number, address) VALUES('$Firstname', '$Lastname', '$Number', '$Address')";
		if (mysqli_query($con, $sql)) {
			header('Location:insert.html');
		}
		else {
			echo "<script>alert('Values are not correct'); window.location.href = 'insert.html';</script>";
		}
	}
	else {
		echo "<script>alert('You are not authorized to view this page.'); window.location.href = 'login.html';</script>";
	}
}


#<============================== Delete ==============================>#
if(isset($_POST['submitdelete'])) {
	if (!isset($_SESSION["login_user"])) {
		$Firstname = $_POST['firstname'];
		$Lastname = $_POST['lastname'];
		$Number = $_POST['number'];
		$Address = $_POST['address'];
		$sql = "DELETE FROM `customer` WHERE `customer`.`number` = $Number ";
		if (mysqli_query($con, $sql)) {
			header('Location:delete.html');
		}
		else {
			echo "<script>alert('User Does not Exist.'); window.location.href = 'delete.html';</script>";
		}
	}
	else {
		echo "<script>alert('You are not authorized to view this page.'); window.location.href = 'login.html';</script>";
	}
}


#<============================== Update ==============================>#
if(isset($_POST['submitupdate'])) {
	if (!isset($_SESSION["login_user"])) {
		$Firstname = $_POST['firstname'];
		$Lastname = $_POST['lastname'];
		$Number = $_POST['number'];
		$Address = $_POST['address'];
		$Updatenumber = $_POST['updatenumber'];
		$sql = "
			UPDATE customer
			SET
				firstname = '$Firstname',
				lastname = '$Lastname',
				number = '$Number',
				address = '$Address'
			WHERE id = (
				SELECT id
				FROM customer
				WHERE number = '$Updatenumber');
			";
		if (mysqli_query($con, $sql)) {
			header('Location:update.html');
		}
		else {
			echo "<script>alert('User Does not Exist.'); window.location.href = 'update.html';</script>";
		}
	}
	else {
		echo "<script>alert('You are not authorized to view this page.'); window.location.href = 'login.html';</script>";
	}
}


#<============================== Search ==============================>#
if(isset($_POST['submitsearch'])) {
	if (!isset($_SESSION["login_user"])) {
		$Number = $_POST['number'];
		$sql = "SELECT * FROM customer WHERE number = '$Number'";
		if (mysqli_query($con, $sql)) {
			$result = $con->query($sql);
			while($row = $result->fetch_assoc()) {
				?>
				<div>
					<div>Firstname : <?php echo $row['firstname']; ?></div>
					<div>Lastname : <?php echo $row['lastname']; ?></div>
					<div>Number : <?php echo $row['number']; ?></div>
					<div>Address : <?php echo $row['address']; ?></div>
				</div>
				<?php
			}
		}
		else {
			echo "<script>alert('User Does not Exist.'); window.location.href = 'search.html';</script>";
		}
	}
	else {
		echo "<script>alert('You are not authorized to view this page.'); window.location.href = 'login.html';</script>";
	}
}


#<============================== END! ==============================>#