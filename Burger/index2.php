<?php 
    header('Content-Type:text/html; charset=iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Titre de notre code -->
        <title> Burger Project </title>
        <!-- Pour prendre en compte les caractères spéciaux (accent, etc)-->
        <meta charset="utf-8"/>
       
        <!-- Le viewport est obligatoire car il permet d'utiliser bootstrap -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <!-- Ce script permet d'utiliser jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!--
           Ces éléments (le css et le javascript de boostrap) sont pour bootstrap, ils sont utilisés avec leur versions en ligne.
           Ils sont ajouté pour rendre le site fun et stylés
       -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <!--On inclus le css -->
        <link rel="stylesheet" href="css/styles.css">
    </head>
   
   
    <body>
        <div class="container site">
                <!-- Le logo avec les fourchette entourant le titre.
               Le logo n'pas une image mais un texte qui a été écrit avec une police spécial et des effets speciaux dans le css.
               -->
<!--
                <h1 class="text-logo"> <span class="glyphicon glyphicon-cutlery"></span> Burger <span class="glyphicon glyphicon-cutlery"></span></h1>
-->
                        <h1 class="text-logo"> 
                <span class="glyphicon glyphicon-cutlery"></span> 
                <a href="accueil.php" style="text-decoration:none;"><span style="color:orange">Burger</span></a>
                <span class="glyphicon glyphicon-cutlery"></span>
            </h1>
            <?php
            
                //emplacement de la base de donnée
                require 'admin/database.php';
                //On recupère le nav
                echo '<nav>
                        <ul class="nav nav-pills">';
                //On se connecte
                $db = Database::connect();
                $statement = $db->query('SELECT * FROM category');
                //On stock toutes les lignes de notre table dans categories
                $categories = $statement->fetchAll();
                foreach($categories as $categorie)
                {
                    if($categorie['id'] == '1')
                    {
                        //On affiche le menu qui est active
                        echo '<li role="presentation" class="active"><a href="#' . $categorie['id'] . '" data-toggle="tab">' .$categorie['name']. '</a></li>';
                    }
                    else
                    {
                        echo '<li role="presentation"><a href="#' . $categorie['id'] . '" data-toggle="tab">' .$categorie['name']. '</a></li>';
                    }
                    
                }
                echo    '</ul>
                    </nav>';
                
                //Contenu des onglets
                echo '<div class="tab-content">';
            
                //Le foreach passe sur chacune des catégories
                foreach($categories as $categorie)
                {
                    if($categorie['id'] == '1')
                    {
                        echo '<div class="tab-pane active" id="' . $categorie['id'] . '">';
                    }
                    else
                    {
                        echo '<div class="tab-pane" id="' . $categorie['id'] . '">';
                    }
                    
                    echo '<div class="row">';
                    
                    //On selectionne une categorie specifique
                    $statement = $db->prepare('SELECT * FROM item WHERE item.idcategories = ?');
                    $statement->execute(array($categorie['id']));
                    
                    //boucle qui passe sur chaque élément de la categorie et on utilise fetch pour avoir chacune de ligne
                    while($item = $statement->fetch())
                    {
                        //On affiche chaque element par son id
                        echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="images/' . $item['image'] . '" alt="Erreur">
                                    <div class="price">' . number_format($item['price'], 2, '.', ''). ' &euro;</div>
                                    <div class="caption">
                                        <h4>' . $item['name'] . '</h4>
                                        <p>' . $item['description'] . '</p>';
                        //Ici on recupère l'id
                        echo                '<a href="admin/panier.php?id=' .$item['id']. '" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                                    </div>
                                </div>
                            </div>';
                    }
                    echo '</div>
                    </div>';
                }
            //On se deconnecte
            Database::disconnect();
            
            //On ferme tab-content
            echo '</div>';
            ?>
            
        </div>
    </body>
</html>