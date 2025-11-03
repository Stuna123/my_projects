<?php
header('Content-Type:text/html; charset=iso-8859-1');
    require 'database.php';
    require 'functionErr.php';

    //Ajout de notre session
    session_start();

    //variables d'erreurs
    $pseudo = $nom = $prenom = $email = $empreinte = $erreur = "";

    //Si les variables ne sont pas vides, on commence le teste
    if(!empty($_POST))
    {
        //Tableau pour l'erreur
        $erreur = array();
        
        $usersType    = checkInput($_POST['type_idType']);
        $pseudo       = checkInput($_POST['pseudo']);
        $nom          = checkInput($_POST['nom']);
        $prenom       = checkInput($_POST['prenom']);
        $email        = checkInput($_POST['email']);
        $empreinte    = checkInput($_POST['mdp']);
        $pwdconfirm   = checkInput($_POST['mdp_conf']);
        $isSuccess    = true;
        
        /*
            On test les variables du formulaires sont vides, si oui on affiche un message d'erreur
        */
        
        if(!empty($usersType))
        {
            $erreur = 'Veuillez remplir ce champ !';
            $isSuccess = false;
        }
        
        //On teste l'expression regulier qui commence de a-z, 0-9 et un _ plusieur fois (on met + à la fin)
        if(empty($pseudo) || !preg_match('/^[a-zA-Z0-9_]+$/', $pseudo) )
        {
            $erreur['pseudo'] = "Votre pseudo n'est pas correct (alphanum&eacute;rique. exemple : toto_12)";
            $isSuccess = false; 
        }
        
        
        if(empty($nom) || !preg_match('/^[a-zA-Z]+$/', $nom))
        {
            $erreur['nom'] = 'Votre nom n\'est pas correct (Ecrivez votre nom correctement sans caractere speciaux, sans chiffre) !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($prenom) || !preg_match('/^[a-zA-Z]+$/', $prenom))
        {
            $erreur['prenom'] = 'Votre prenom n\'est pas correct (Ecrivez votre prenom correctement sans caractere speciaux, sans chiffre) !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $erreur['email'] = 'Votre email n\'est pas correct !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($empreinte) || $empreinte != $pwdconfirm)
        {
            $erreur['mdp'] = "Veuillez entrez un mot de passe valide";
            $isSuccess = false;
        }
        
        //Si les champs ne sont pas correcte, on affiche un message d'erreur sinon on ajoute l'utilisateur
        if($isSuccess)
        {
            
            //hash le mot de passe
            $empreinte = password_hash($empreinte, PASSWORD_DEFAULT);
            
            //Connexion
            $db = Database::connect();
            
            
            //On insert
            $statement = $db->prepare("INSERT INTO `utilisateur` (`iduser`, `pseudo`, `nom`, `prenom`, `email`, `password_hash`, `type_idType`) VALUES (NULL, '$pseudo', '$nom', '$prenom', '$email', '$empreinte', 1)");
            
            //die('Erreur de mot de passe' .$empreinte);
             
            //On execute la requete
            $statement->execute(array($pseudo,$nom,$prenom, $email, $empreinte));
            
            //On se deconnecte
            Database::disconnect();
            
            header("Location: membre.php");
            exit;
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
                <h1><strong><center>Ajouter un membre</center></strong></h1>
                <br />
                
                <?php 
                    if(!empty($erreur)):
                ?>
                <!-- On fait un message d'alerte à l'utilisateur -->
                <div class="alert alert-danger">
                    <p> Le formulaire n'est pas rempli ou pas correctement rempli ! </p>
                    
                    <ul>
                        <!-- On affiche les erreur-->
                        <?php
                            foreach($erreur as $err):
                        ?>

                            <li><?= $err; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <?php endif;?>
                
                <!-- Formulaire d'inscription -->
                <form class="form" role="form" action="" method="POST">
                    
                    <!-- On recupère les differents qui peuvent être inscritent -->
<!--
                    
                    <div class="form-group">
                        <select option="2" class="form-control" name="type_inscription" id="type_inscription">
                        <label for="type_inscription">Type</label>
                        </select>
                    </div>
-->
                    <div class="form-group">
                    <label for="users">Vous &ecirc;tes </label>
                            <select class="form-control" id="type_idType" name="type_idType">
                                <?php
                                    $db = Database::connect();
                                    foreach($db->query('SELECT * FROM type_users') as $row)
                                    {
                                        echo '<option value="' . $row['id'] . '">' . $row['nom'] . '</option>';
                                        
                                    }
                                    Database::disconnect();
                                ?>
                            </select>
                        </div>
                    
                    <div class="form-group">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Entrez votre pseudo" class="form-control"  >
                    </div>
                    
                    <div class="form-group">
                        <label for="nom">Nom </label>
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Entrez votre nom"  >
                    </div>
                    
                    <div class="form">
                        <div class="form-group">
                            <label for="prenom">Prenom </label>
                            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Entrez votre prenom"   >
                        </div>
                    </div>
                    
                    <div class="form">
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="jc@gmail.com"  >
                        </div>
                    </div>
                    
                    <div class="form">
                        <div class="form-group">
                            <label for="mdp">Mot de passe </label>
                            <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Entrez un mot de passe s&eacute;curis&eacute"   >
                        </div>
                    </div>
                
                    <div class="form">
                        <div class="form-group">
                            <label for="mdp_conf">Confirmation du mot de passe </label>
                            <input type="password" class="form-control" name="mdp_conf" id="mdp_conf" placeholder="Entrez un mot de passe s&eacute;curis&eacute;"  >
                        </div>
                    </div>
                    
                    <div class="form-actions">
                         
                            <button type="submit" class="btn btn-primary"> Ajouter </button>
                        
                            <span style="margin-right:10px"></span>
                        
                            <a class="btn btn-default" href="membre.php"><span class="glyphicon glyphicon-arrow-left"></span> Revenir aux membre</a>
                    </div>
                    <br />
                    <a href="login.php" style="text-decoration:none"> 
                        <strong>D&eacute;j&agrave; inscrit ? Connectez-vous !</strong>
                    </a>
                    
                </form>
            </div>
        </div>
    </body>

</html>