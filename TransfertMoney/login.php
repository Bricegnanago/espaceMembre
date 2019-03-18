<?php    
session_start();
    require 'partials/functions.php';  
?>


<?php require 'partials/header.php';?>
<?php 

        
        if(isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
            require "partials/db.php";
            $req = $pdo->prepare("SELECT * FROM users WHERE username= :username OR email= :username AND confirmed_at IS NOT NULL ");
            $req->execute(['username' => $_POST['username']]);
            $user = $req->fetch();
            if(password_verify($_POST['password'], $user->password)){
                $_SESSION['auth'] = $user;
                $_SESSION['flash']['success'] = "Vous êtes maintenant connecté";
                header('Location: account.php');
                exit();
            }else{
                $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
            }
            debug($user);
        }
        
    ?>


    <h1>Se Connecter</h1>

    <form action="" method="post" class="col-lg-8">
        <div class="form-group">
            <label for="">Pseudo ou l'email</label>
            <input type="text" name="username" class="form-control">
        </div>       

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control">
        </div>

      
        <button class="btn btn-primary" type="submit" name="connexion">Se connecter</button>
    </form>




<?php require 'partials/footer.php';?>