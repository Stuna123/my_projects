<?php header('Content-Type:text/html; charset=iso-8859-1'); ?>
<?php

    //On protège toutes nos pages
    //session_start();
    /* On verifie s'il y'a la session sinon on renvoie vers le login */
    //if(!isset($_SESSION['email']))
    //{
    //    header("Location: login.php");
    //}

//On se connecte
    require 'database.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
    $db = Database::connect();

    //Jointure de deux tables item et category
    $statement = $db->prepare(' Select item.id, item.name, item.description, item.price, item.image, category.name as categorie 
                                From item Join category On item.idcategories = category.id 
                                Where item.id = ?');
    
    $statement->execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();

    //securité
    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
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
                    <h1><strong>Voir un &eacute;l&eacute;ment</strong></h1>
                    <br />
                    <form>
                        <div class="form-group">
                            <label>Nom: </label><?php echo ' ' . $item['name']; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Description: </label><?php echo ' ' . $item['description']; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Prix: </label><?php echo ' ' . number_format((float)$item['price'],2,'.','') . ' '; ?><span>&euro;</span>
                        </div>
                        
                        <div class="form-group">
                            <!-- &eacute : é 
                            https://www.scriptol.fr/creation-site-web/accents-html.php
                            -->
                            <label>Cat&eacute;gorie: </label><?php echo ' ' . $item['categorie']; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Image: </label><?php echo ' ' . $item['image']; ?>
                        </div>
                    </form>
                    <br />
                    <div class="form-actions">
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                    
                </div>
                
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/' .$item['image'] ?>" alt="Erreur">
                        <div class="price"><?php echo number_format((float)$item['price'],2,'.','') . ' '; ?><span>&euro;</span> </div>
                        <div class="caption">
                            <h4><?php echo $item['name'];?></h4>
                            <p><?php echo $item['description'];?></p>
                        </div>
                    </div>
                </div>
                        
            </div>
        </div>
        
    </body>
</html>