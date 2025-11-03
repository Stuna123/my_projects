<?php header('Content-Type:text/html; charset=iso-8859-1');?>

<?php

//On se connecte
    require 'database.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
        
//    $db = Database::connect();
//    $statement = $db->prepare(' Select items.id, items.nom, items.description, items.prix, items.image, categories.nom as categorie 
//                                From items Left Join categories On items.categorie = categories.id 
//                                Where items.id = ?');
//    
//    $statement->execute(array($id));
//    $item = $statement->fetch();
//    Database::disconnect();

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
        <title>Burger Project</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> <span class="glyphicon glyphicon-shopping-cart"></span> Erreur <span class="glyphicon glyphicon-shopping-cart"></span> <span class="glyphicon glyphicon-cutlery"></span></h1>
        
        <div class="container admin">
            <h1><strong><center>Le pseudo que vous avez choisi existe d&eacute;j&agrave;</center></strong></h1>
            <br >
            <div class="row">
                    
                    <center>
                    
                    <a href="inscription.php" style="text-decoration:none;"> Cliquez ici pour revenir &agrave; l'inscription !</a>
                    
                        <?php 
                        
                        ?>
                        
                    </center>
                
            </div>
        </div>
        
    </body>
</html>