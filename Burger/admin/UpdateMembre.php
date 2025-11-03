<?php
header('Content-Type:text/html; charset=iso-8859-1');
    require 'database.php';
    require 'functionErr.php';

    //Ajout de notre session
    session_start();

    //Pour le premier passage on recupère l'id
    if(!empty($_GET['iduser']))
    {
        $iduser = checkInput($_GET['iduser']);
    }

    //variables d'erreurs
    $pseudo = $nom = $prenom = $email = $erreur = "";

    //Si les variables ne sont pas vides, on commence le teste
    if(!empty($_POST))
    {
        
        $usersType    = checkInput($_POST['type_idType']);
        $pseudo       = checkInput($_POST['pseudo']);
        $nom          = checkInput($_POST['nom']);
        $prenom       = checkInput($_POST['prenom']);
        $email        = checkInput($_POST['email']);
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
        
        //Si les champs ne sont pas correcte, on affiche un message d'erreur sinon on ajoute l'utilisateur
        if($isSuccess)
        {
            //Connexion
            $db = Database::connect();
            
                        
            $statement = $db->prepare("UPDATE utilisateur SET pseudo = ?, nom = ?, prenom = ?, email = ?, type_idType = ?  WHERE iduser = ?");               
            $statement->execute(array($pseudo,$nom,$prenom,$email,$usersType,$iduser));
            
            //On se deconnecte
            Database::disconnect();
            
            header("Location: membre.php");
        }
    }
    else  if(empty($_GET['iduser']))
    {
        //On se connecte
        $db = Database::connect();
        
        //On recupère l'info de la ligne qui est sur la bdd via son id
        $statement = $db->prepare("SELECT * FROM utilisateur WHERE iduser = ?");
        
        //L'id qui est recuperer est donné ici
        $statement->execute(array('iduser'));
        
        //On remplit les valeurs avec celui de la bdd automatiquement dans le formulaire
        $item = $statement->fetch();
        
        $usersType    = $item['type_idType'];
        $pseudo       = $item['pseudo'];
        $nom          = $item['nom'];
        $prenom       = $item['prenom'];
        $email        = $item['email'];
        $iduser       = $item['iduser'];
        
        //On se deconnecte
        Database::disconnect();
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
                <div class="col-sm-6">
                    <h1> <span class="glyphicon glyphicon-user"></span> <strong> Modifier un membre </strong></h1>
                    <br />
                    <!-- Les valeurs sont renvoyer sur cette page-->
                    <form class="form" action="<?php echo 'UpdateMembre.php?id='.$iduser;?>" role="form" method="post" enctype="multipart/form-data">

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
                        <br />
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Confirmer </button>
                            <a class="btn btn-primary" href="membre.php"><span class="glyphicon glyphicon-arrow-left"></span> Retourner &agrave; la page membre</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        
    </body>
</html>