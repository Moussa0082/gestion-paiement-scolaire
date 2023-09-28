   
  <?php

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'fees') or die("Impossible de se connecter à MySQL : " . mysqli_error($conn));

if (isset($_POST['submit'])) {
    // Vérifie si les données POST existent
    if (isset($_POST['name'], $_POST['username'], $_POST['password'])) {
        // Prépare la requête SQL pour l'insertion
        $req = $conn->prepare('INSERT INTO users (name, username, password) VALUES (?, ?, ?)');
        
        // Lie les valeurs aux paramètres de la requête
        $req->bind_param('sss', $_POST['name'], $_POST['username'], $_POST['password']);
        
        // Exécute la requête
        if ($req->execute()) {
            echo "Utilisateur inséré avec succès !";
        } else {
            echo "Erreur lors de l'insertion de l'utilisateur : " . $req->error;
        }
        
        // Ferme la requête
        $req->close();
    } else {
        echo "Toutes les données nécessaires ne sont pas fournies.";
    }
}

// Ferme la connexion à la base de données
$conn->close();

?>



      <!DOCTYPE html>
<html lang="en">
<?php 
// session_start();
// include('./db_connect.php');
// ob_start();
// // if(!isset($_SESSION['system'])){            
// 	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
// 	foreach($system as $k => $v){
// 		$_SESSION['system'][$k] = $v;
// 	}
// // }
// ob_end_flush(); 





?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">   
                                                                        
  <title>gestion scolaire</title>
 	
<?php include('./header.php'); ?>
<?php 
// if(isset($_SESSION['login_id']))
// header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

</style>

<body class="bg-dark">


  <main id="main" >
  	
  		<div class="align-self-center w-100">
		<h4 class="text-white text-center"><b>Systeme de gestion scolaire</b></h4>
  		<div id="login-center" class="bg-dark row justify-content-center">
  			<div class="card col-md-4">
  				<div class="card-body">
                

  					<form method="POST" action="register.php" >
  						<div class="form-group">
  							<label for="username" class="control-label">Nom</label>
  							<input type="text" id="username" name="name" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="email" class="control-label">Nom d'utilisateur</label>
  							<input type="text" id="email" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password"  class="control-label">Mot de passe</label>
  							<input type="password" name="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button type="submit" name="submit" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Créer un compte</button></center>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
// 	$('#login-form').submit(function(e){
// 		e.preventDefault()
// 		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
// 		if($(this).find('.alert-danger').length > 0 )
// 			$(this).find('.alert-danger').remove();
// 		$.ajax({
// 			url:'ajax.php?action=login',
// 			method:'POST',
// 			data:$(this).serialize(),
// 			error:err=>{
// 				console.log(err)
// 		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

// 			},
// 			success:function(resp){
// 				if(resp == 1){
// 					location.href ='index.php?page=home';
// 				}else{
// 					$('#login-form').prepend(`<div class="alert alert-danger">Nom d'utilisateur ou mot de pass incorrect.</div>`)
// 					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
// 				}
// 			}
// 		})
// 	})
// </script>	
</html>