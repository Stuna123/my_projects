<?php 
    //On protège toutes nos pages
    session_start();
    /* On verifie s'il y'a la session sinon on renvoie vers le login */
    //if(!isset($_SESSION['email']))
    //{
     //   header("Location: login.php");
    //}

    require 'database.php';
    
//On recupère l'id pour le premier passage
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
//On recupère l'id pour la deuxième fois mais cette fois-ci avec le post
    if(!empty($_POST['id']))
    {
        //Dans le cas ici présent, on souhaite supprimer
        $id = checkInput($_POST['id']);
        //On se connecte 
        $db = Database::connect();
        //On prepare la requete
        $statement = $db->prepare("DELETE FROM utilisateur WHERE iduser = ?");
        //On execute
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: membre.php");
    }

    //Sécurité des variables
    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Burger Porject </title>
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
   
                    <h1><strong>Supprimer un membre</strong></h1>
                <br />
                <form class="form" role="form" action="DeleteMembre.php" method="post">
                    <!-- On rend l'id qui sera recuperer invisible à l'utilisateur -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <p class="alert alert-warning">Voulez-vous vraiment supprimer ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="membre.php">Retour</a>
                    </div>  
                </form>
            </div>
        </div>
    </body>
</html>