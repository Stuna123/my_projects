<?php 
header('Content-Type:text/html; charset=iso-8859-1');

    session_start();
    /* On verifie s'il y'a la session sinon on renvoie vers le login */
    //if(!isset($_SESSION['email']))
    //{
      //  header("Location: login.php");
    //}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Burger Project </title>
        <meta charset="utf-8"/>
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
                <h1><a href="membre.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user"></span> Voir Membres </a>
                    
                    <span style="margin-left:5px;"></span>
                    
                <a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter un aliments </a></h1>
                
                
                
                
                <!-- 
                    Table qui contiendra nos éléments
                    table-stripped ce qui fait qu'il ait une ligne grise et blanche 
                -->
                <table class="table table-striped table-bordered">
                    <thead>
                        <!-- tr c'est la ligne de la table-->
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix(&euro;)</th>
                            <!-- &eacute; : é -->
                            <th>Cat&eacute;gorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        //On utilise notre bdd
                        require 'database.php';    
                        //On retourne la connexion dans la variable db
                        //Pour acceder à la classe on fait :: comme c'est une fonction statique
                        $db = Database::connect();
                        //On sélectionne nos informations dans la db pour recuperer les resultats de notre table
                        //On fait la jointure de item et categorie
                        $statement = 
                            $db->query('Select item.id, item.name, item.description, item.price, category.name as NomCategories 
                                        From item LEFT JOIN category ON item.idcategories = category.id
                                                    Order by item.id desc');
                        //On affiche nos données récupérées
                        while($item = $statement->fetch())
                        {
                            //On va importer les éléments depuis la bdd en les appelant par les noms de leur colonnes
                            echo '<tr>';
                            echo '<td>' .$item['name']. '</td>';
                            echo '<td>' .$item['description']. '</td>';
                            //si le prix n'pas en float on le transforme en float
                            //On met en format de nombre et 2 c'est le nombre des chiffre qu'il y'a après la virgule (notre cas c'est cad .90), . c'est le separateur
                            echo '<td>' .number_format((float)$item['price'],2,'.', ''); '</td>';
                            echo '<td>' .$item['NomCategories']. '</td>';
                                // On pose une largeur fixe pour le bouton
                            echo'<td width="300">';
                            echo    '<a class="btn btn-default" href="view.php?id=' . $item['id'] . '"> <span class="glyphicon glyphicon-eye-open"> </span> Voir</a>';
                            //On met de l'espace entre les boutons
                            echo ' ';
                            echo    '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"> <span class="glyphicon glyphicon-pencil"> </span> Modifier</a>';
                            echo '  ';
                            echo    '<a class="btn btn-danger" href="delete.php?id=' . $item['id'] . '"> <span class="glyphicon glyphicon-remove"> </span> Supprimer</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        Database::disconnect();
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
    </body>
</html>