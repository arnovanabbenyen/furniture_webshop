<?php

    include_once(__DIR__ . "/classes/User.php");


	if(!empty($_POST)){
		try{
            $user = new User();
            $user->setFirst_name($_POST['first_name']);
            $user->setLast_name($_POST['last_name']);
            $user->setEmail($_POST['email']);
            if($user->emailExists($_POST['email'])) {
                throw new Exception('This email is already registered.');
            }
            $user->setPassword($_POST['password']);
            $user->save();
            header('Location: login.php');
          }
          catch(Exception $e){
            $error = $e->getMessage();
          }
	}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<div class="henkLogin">
    <div class="henkLayer">
    <div class="form__login">
        <img src="Images/studioHenk_Logo.jpg" alt="" class="logo">
        <h2>Create an account</h2>
    <form action="" method="post">
        <?php if(isset($error)): ?>
        <div class="form__error">
			<p><?php echo $error; ?></p>
		</div>
        <?php endif; ?>

        <div class="form__field">
            <label for="first_name">First name</label>
            <input type="text" name="first_name">
        </div>

        <div class="form__field">
            <label for="last_name">Last name</label>
            <input type="text" name="last_name">
        </div>
        
        <div class="form__field">
            <label for="Email">Email</label>
            <input type="text" name="email">
        </div>

        <div class="form__field">
            <label for="Password">Password</label>
            <input type="password" name="password">
        </div>

        <div class="login">
            <input type="submit" value="Create" class="btn">
        </div>
    </form>
</div>
</div>
<div class="bgi"></div>
</div>
    
</body>
</html>