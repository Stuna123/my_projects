<?php

    //On protège toutes nos pages
    session_start();
    /* On verifie s'il y'a la session sinon on renvoie vers le login */
    //if(!isset($_SESSION['email']))
    //{
      //  header("Location: login.php");
    //}

header('Content-Type:text/html; charset=iso-8859-1');
    require 'database.php';
    //On crée des variables pour les erreurs des champs du formulaires
    $NomErreur = $DescriptionErreur = $PrixErreur = $CategorieErreur = $ImageErreur = $name = $description = $price = $idcategories = $image = "";

    //On teste si le post ne pas vide et dans ce cas, c'est le 2e passage
    if(!empty($_POST))
    {
        $name               = checkInput($_POST['name']);
        $description        = checkInput($_POST['description']);
        $price              = checkInput($_POST['price']);
        $idcategories       = checkInput($_POST['idcategories']);
        /*$_FILES variable global qui nous permet de chercher la variable image et dans cette variable c'est le name ('name')*/
        $image              = checkInput($_FILES['image']['name']);
        //chemin de l'image
        $imagePath          = '../images/' . basename($image);
        $imageExtension     = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess          = true;
        $isUploadSuccess    = false;
        
        /*
            On test les variables du formulaires sont vides, si oui on affiche un message d'erreur
        */
        if(empty($name))
        {
            $NomErreur = 'Veuillez remplir ce champ !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($description))
        {
            $DescriptionErreur = 'Veuillez remplir ce champ !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($price))
        {
            $PrixErreur = 'Veuillez remplir ce champ !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($idcategories))
        {
            $CategorieErreur = 'Veuillez remplir ce champ !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        
        if(empty($image))
        {
            $ImageErreur = 'Veuillez remplir ce champ !';
            //Comme c'est un echec eh bien isSuccess recoit false
            $isSuccess = false;
        }
        //Dans le cas où l'image ne pas vide
        else
        {
            $isUploadSuccess = true;
            //On teste les differentes extension de l'image 
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
            {
                //On affiche l'erreur
                $ImageErreur = "Les fichiers des images qui sont permissent sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            
            //On teste si le chemin est deja l cad si l'image existe deja
            if(file_exists($imagePath))
            {
                //On affiche l'erreur de l'image
                $ImageErreur = "Le fichier que vous essayez existe";
                $isUploadSuccess = false;
            }
            
            //On limite la taille de l'image
            if($_FILES["image"]["size"] > 500000)
            {
                //On affiche l'erreur
                $ImageErreur = "L'image ne doit pas depasser les 500kb";
                $isUploadSuccess = false;
            }
            
            //Si l'upload est true 
            if($isUploadSuccess)
            {
                /*
                    move_uploaded_file est fonction qui va prendre notre image qui dans un endroit temporaire et le mettre sur le vrai chemin de l'image qui $imagePath
                */
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $ImageErreur = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }
        }
        
        /*
            On teste si isSuccess et isUploadSuccess ont été un succèss
        */
    
        if($isSuccess && $isUploadSuccess)
        {
            //On se connect
            $db = Database::connect();
            //On insert
            $statement = $db->prepare("INSERT INTO item (name,description,price,image,idcategories) values(?,?,?,?,?)");
            //On execute avec les valeurs prises dans le formulaire
            $statement->execute(array($name,$description,$price,$image,$idcategories));
            //On se decoonecte
            Database::disconnect();
            //On change d'adresse pour aller à index.php 
            header("Location: index.php");
        }
    }

//Securité des données
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
                
                    <h1><strong>Ajouter un nouveau &eacute;l&eacute;ment</strong></h1>
                    <br />
                    <!-- Les valeurs sont renvoyer sur cette page-->
                    <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom: </label>
                            <!-- 
                                type : texte, 
                                class : form-control pour donner du style
                                name pour le recuperer avec une methode dans notre c'est post
                                placeholder : titre d'exemple d'un texte à mettre par user.
                                $name : on la valeur de notre variable dans input du formulaire
                                for dans le label redirige à l'input via l'id donné
                            -->
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                            <!-- message d'erreur -->
                            <span class="help-inline"><?php echo $NomErreur; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                            <span class="help-inline"><?php echo $DescriptionErreur; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="pix">Prix: (en &euro;)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $PrixErreur?></span>
                        </div>
                        
                        <div class="form-group">
                            <!-- &eacute : é 
                            https://www.scriptol.fr/creation-site-web/accents-html.php
                            -->
                            <label for="idcategories">Cat&eacute;gorie: </label>
                            <select class="form-control" id="idcategories" name="idcategories">
                                <?php
                                    $db = Database::connect();
                                    foreach($db->query('SELECT * FROM category') as $row)
                                    {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                        
                                    }
                                    Database::disconnect();
                                ?>
                            </select>  
                            <span class="help-inline"><?php echo $CategorieErreur;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">S&eacute;ctionner une image: </label>
                            <input type="file" id="image" name="image">
                            <span class="help-inline"><?php echo $ImageErreur;?></span>
                        </div>
                    
                    <br />
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                 </form>       
            </div>
        </div>
        
    </body>
</html>