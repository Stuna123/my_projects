<?php
header('Content-Type:text/html; charset=iso-8859-1');
    require 'database.php';
    
    //Ajout de la sesssion
    session_start();

    //On crée des variables pour les erreurs des champs du formulaires
    $email = $password = $erreur = "";

    //On teste si le post ne pas vide et dans ce cas, c'est le 2e passage
    if(!empty($_POST))
    {
        $email = checkInput($_POST['email']);
        $password = checkInput($_POST['password']);
        
        //test
        //Mdp : tabora
        
        //On se connecte à la base de donnée
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM utilisateur WHERE email = ? and password_hash = ?");
        $statement->execute(array($email,$password));
        Database::disconnect();
        
        //On verifie
        if($statement->fetch())
        {
            $_SESSION['email'] = $email;
            header("Location: index.php");
        }
        else
        {
            $erreur = "Email ou mot de passe incorrect";
        }
    }

//Securité des données
function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    
    //On retourne la donnée
    return $data;
}

?>

<!DOCTYPE html>
<html> 
    <head>
        <title> Burger Project </title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/styles.css">
        
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger <span class="glyphicon glyphicon-cutlery"></span></h1>
        
        <div class="container admin">
            <div class="row">
                <!-- 
                    btn btn-success pour avoir la couleur verte dans le bouton
                    btn-lg ça rend grand (large)
                    glyphicon-plus pour mettre plus dans le bouton ajouter avant le mot
                -->
                <!-- moitier de la fenetre -->
                
                    <h1><strong> Se connecter </strong></h1>
                    <br />
                    <!-- Les valeurs sont renvoyer sur cette page-->
                    <form class="form" role="form" action="login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email: </label>
                            <!-- 
                                type : email, 
                                class : form-control pour donner du style
                                name pour le recuperer avec une methode dans notre c'est post
                                placeholder : titre d'exemple d'un texte à mettre par user.
                                $nom : on la valeur de notre variable dans input du formulaire
                                for dans le label redirige à l'input via l'id donné
                                required pour dire que le champ ne peut pas rester vide
                            -->
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                            <!-- message d'erreur -->
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Mot de passe:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" value="<?php echo $password; ?>" required>
                        </div>
                    
                        <p>
                            <span class="help-inline"><?php /*echo '<script> alert("' . $erreur . '");</script>';*/ echo $erreur; ?></span>
                        </p>
                    
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"> Connexion </button>
                        
                         <span style="margin-right:10px"></span>
                        
                        <button class="btn btn-" class="btn btn-default"> 
                            <a href="../accueil.php" style="text-decoration:none"><span class="glyphicon glyphicon-arrow-left"></span> Retour &agrave; l'acceuil </a> 
                        </button>
                    </div>
                        <br />
                        <p>
                            <strong>
                                Vous n'&ecirc;tes pas encore inscrit ? <a href="inscription.php" style="text-decoration:none"> Veuillez vous inscrire ici </a>!
                            </strong>
                        </p>
                 </form>       
            </div>
        </div>
        
    </body>
</html>