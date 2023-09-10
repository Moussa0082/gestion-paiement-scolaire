<?php
$error=null;
$success=null;
$username=null;
$password=null;

if(!empty($_POST['username'])){

  $file = __DIR__ . DIRECTORY_SEPARATOR . 'test'. DIRECTORY_SEPARATOR. date('Y-m-d');
     file_put_contents($file,  $email, FILE_APPEND);
	$username=$_POST['username'];
	if(filter_var($username, FILTER_VALIDATE_EMAIL)){
		$success= "Votre username a bien été envoyé";
	}else{
		$error= "username invalide";
	}
}


?>
 <!-- message affichage  -->
     
<?php   if($success): ?>
    <div class="alert alert-success">
       <?php   $success; ?>
    </div>
<?php   endif ?>
<?php   if($error): ?>
    <div class="alert alert-danger">
       <?php   $error; ?>
    </div>
<?php   endif ?>
