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
        
        <div class="container adminMembre">
            <div class="row">
                <!-- 
                    btn btn-success pour avoir la couleur verte dans le bouton
                    btn-lg ça rend grand (large)
                    glyphicon-plus pour mettre plus dans le bouton ajouter avant le mot
                -->
                
                <center style="color:white">
                    <h1> Tableau d'ajout membre </h1>
                    <a href="../accueil.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span> Accueil </a>
                    <p></p>
                </center> 
                
                
                
                <table class="table">
                    <thead>
                      <tr class="info">
                        <th>Administrateur</th>
                        <th>Systeme</th>
                        <th>Restaurateur</th>
                        <th>Clients</th>
                        <th>Aliments</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><h1><a href="AjoutMembre.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user"></span> Admin </a></h1></td>
                        <td>
                <h1> <a href="AjoutMembre3.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user"></span> Systeme </a> </h1>
                    </td>
                        <td>                <h1><a href="AjoutMembre2.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user"></span> Restaurateur </a></h1></td>
                        <td>                
                            <h1> <a href="index.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user"></span> Client</a> </h1>
                        </td>                        
                          
                        <td>                
                            <h1> <a href="index.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-eye-open"></span> aliments </a> </h1>
                        </td>
                      </tr>
                    </tbody>            
                </table>
                    
                    <span style="margin-left:5px;"></span>
                    
<!--                <h1> <a href="index.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-eye-open"></span> Voir aliments </a> </h1>-->
                
                
                
                <!-- 
                    Table qui contiendra nos éléments
                    table-stripped ce qui fait qu'il ait une ligne grise et blanche 
                -->
                <table class="table">
                    <thead>
                        <!-- tr c'est la ligne de la table-->
                        <tr tr class="success">
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
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
                            $db->query('Select u.iduser, u.pseudo, u.nom, u.prenom, u.email, u.password_hash, tu.nom as CategorieMembre 
                                        From utilisateur as u LEFT JOIN type_users as tu ON u.type_idType = tu.idtype
                                                    Order by u.iduser desc');
                        //On affiche nos données récupérées
                        while($member = $statement->fetch())
                        {
                            //On va importer les éléments depuis la bdd en les appelant par les noms de leur colonnes
                            echo '<tr tr class="info">';
                            echo '<td>' .$member['pseudo']. '</td>';
                            echo '<td>' .$member['nom']. '</td>';
                            echo '<td>' .$member['prenom']. '</td>';
                            echo '<td>' .$member['email']. '</td>';
                            echo '<td>' .$member['password_hash']. '</td>';
                            echo '<td>' .$member['CategorieMembre']. '</td>';
                            // On pose une largeur fixe pour le bouton
                            echo'<td width="20">';
                            //On met de l'espace entre les boutons
                            echo ' ';
                            echo    '<a class="btn btn-primary" href="UpdateMembre.php?id=' . $member['iduser'] . '"> <span class="glyphicon glyphicon-pencil"> </span> Modifier</a>';
                            echo '  ';
                            echo    '<a class="btn btn-danger" href="DeleteMembre.php?id=' . $member['iduser'] . '"> <span class="glyphicon glyphicon-remove"> </span> Supprimer</a>';
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