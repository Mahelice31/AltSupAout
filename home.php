
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="class1.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>Connexion</title>
    </head>

<body class="body-login">
    <img src="CampusSciencesU.jpeg" class="img-fluid">
    <div class="split left">
    <div class="centered">
    
    </div>    
    </div>
    <div class="split ">
        <img src="logo.png" class="images">
        <div class="centered">
           <?php

                $db=mysqli_connect('localhost','root','','alt_sup_project');

                if(isset($_POST['submit'])) {
                    $email=mysqli_real_escape_string($db,$_POST['email']);
                    $mdp=mysqli_real_escape_string($db,$_POST['mdp']);
                    $query="SELECT*FROM utilisateurs WHERE email='$email' and mdp='$mdp'";
                    $selection=mysqli_query($db,$query);
    
                    if (mysqli_num_rows($selection)==1) {
                        $user=mysqli_fetch_assoc($selection);
                        session_start();
                        $_SESSION['email'] = $email;
                        $sessionID=session_id();
    
                if ($user["id_role"] == 1) {
                    $_SESSION['logged_in'] = 1;
                    header("Location: DirecteurCre.php");
                    exit;
                }
    
                if ($user["id_role"] == 2) {
                    $_SESSION['logged_in'] = 2;
                    header("Location: CRE.php");
                    exit;
                }
    
                if ($user["id_role"] == 3) {
                    $_SESSION['logged_in'] = 3;
                    header("Location: ResponsablePedagogique.php");
                    exit;
                }
                if ($user["id_role"] == 4) {
                    $_SESSION['logged_in'] = 4;
                    header("Location: SuiveursAlternant.php");
                    exit;
                }
            }
    
            else {
                echo "Adresse mail/mot de passe incorrects";
            }
        }
        else {
           echo "Ce compte n'existe pas";
        }

?>
    <body class="body-login">
        <div class="div-login">
            <h1>Connexion</h1>
            <form class="" method="post">
                <div class="texte">
                    <input type="text" name="email" required>  
                    <span></span>
                    <label>Adresse mail</label>
                </div>
                <div class="texte">
                    <input type="password" name="mdp" required>
                    <span></span>
                    <label>Mot de passe</label>
                </div>
                <div>
                <input type="submit" name="submit" value="Se connecter">
                </div>
                <div class="register-link">
                <p>En cas de problème <a href="register.php">contactez nous</a></p>
                </div>
            </form>
        </div>
    </body>
    </body>
            
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>