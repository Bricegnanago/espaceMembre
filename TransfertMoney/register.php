<!-- traitement php -->
<?php 
    require_once 'partials/functions.php';
    session_start();
    if(isset($_POST['connexion'])){
        $errors = array();
        require_once 'partials/db.php'; 

        if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
            $errors['username'] = "Veuillez saisir votre nom utilisateur";
        }else{
            $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $req->execute([$_POST['username']]);
            $user = $req->fetch();
            $pdo->lastInsertId();
            if($user){
                $errors['username'] = "Ce pseudo est déjà utilisé";
            }
        }            

        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Votre Email n'est pas valide";
        }else{
            $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $req->execute([$_POST['email']]);
            $user = $req->fetch();
            
            if($user){
                $errors['email'] = "Cette adresse email est déjà utilisée";
            }
        }
        if(empty($_POST['password']) || ($_POST['password'] != $_POST['password_confirm'])){
            $errors['password'] = "Mot de passe non valide";
        }
        if(empty($errors)){
            $to = $_POST['email'];

            $subject = " - ACTIVATION DE COMPTE";

            $req = $pdo->prepare("INSERT INTO users SET username= ?, password= ?, email = ?, confirmation_token= ?");
            // $pdo->commit();  
                   
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $token = str_random(60);
            ob_start();
            $token = str_random(60);
            require('templates/emails/activation.tmpl.php');            
            $content = ob_get_clean();
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type : text/html; charset=iso8859-1' . "\r\n";
            $req->execute([$_POST['username'], $password, $_POST['email'], $token]);            
            $user_id = $pdo->lastInsertId();
            $_SESSION['user']['id'] = $user_id;
            mail($to, $subject, $content, $headers);
            $_SESSION['flash']['success'] = "Un email de confirmation vous a été envoyé pour valider votre compte";
            header('Location: login.php'); 
            exit();
        }                

        // debug($errors);
        
    }
?>

<?php require 'partials/header.php'; 
  
?>

    <h1>S'inscrire</h1>
    <?php if(!empty($errors)):?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas rempli le formulaire correctement</p>        
                <ul>
                    <?php foreach($errors as $error):?>
                    
                        <li><?= $error; ?></li>
                    <?php endforeach;?>
                </ul>                            
        </div>
<?php endif;?>
    <form action="" method="post" class="col-lg-8">
        <div class="form-group">
            <label for="">Pseudo</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Confirmer votre mot de passe</label>
            <input type="password" name="password_confirm" class="form-control">
        </div>
        <button class="btn btn-primary" type="submit" name="connexion">S'inscrire</button>
    </form>
    
<?php require 'partials/footer.php'?>
