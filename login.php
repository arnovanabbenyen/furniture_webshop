<?php

    include_once(__DIR__ . "/classes/Db.php");

    function canLogin($email, $password){
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM user WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user){
            $hash = $user['password'];
            if(password_verify($password, $hash)){
                return true;
            }
            else{
                return false;
            }
        }
    }

	if(!empty($_POST)){
		$email = $_POST['email'];
		$password = $_POST['password'];

		if(canLogin($email, $password)){
	    	session_start();
			$_SESSION['logged in'] = true;
			$_SESSION['email'] = $email;
			header('Location: index.php');
		}
		else{
			$error = true;
		}
		
	}
	

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<div class="henkLogin">
    <div class="henkLayer">
    <div class="form__login">
        <img src="Images/studioHenk_Logo.jpg" alt="" class="logo">
        <h2>Login to your account</h2>
    <form action="" method="post">
        <?php if(isset($error)): ?>
        <div class="form__error">
			<p>Your email or password is incorrect. Try again.</p>
		</div>
        <?php endif; ?>
        
        <div class="form__field">
            <label for="Email">Email</label>
            <input type="text" name="email">
        </div>

        <div class="form__field">
            <label for="Password">Password</label>
            <input type="password" name="password">
        </div>

        <div class="login">
            <input type="submit" value="Login" class="btn">
        </div>

        <div class="signOption" >
            <p>Don't have an account yet? <a href="signup.php">Sign up!</a> </p>
        </div>
    </form>
</div>
</div>
<div class="bgi"></div>
</div>
    
</body>
</html>