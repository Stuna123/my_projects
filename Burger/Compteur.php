<?php
$connexion = mysql_connect('localhost', 'root', '') OR die('Erreur de connexion');
mysql_select_db('webburger') OR die('Sélection de la base impossible');

$requete1 = mysql_query('SELECT date FROM Order WHERE paid = 1 ORDER BY date LIMIT 1');  
     //Ici vous placez vos autres requêtes 
	 mysql_close();
	 
	 

<div id="compte_a_rebours"></div>
<script type="text/javascript">
 
var compte_a_rebours = document.getElementById("compte_a_rebours");
var date_actuelle = new Date();
var date_evenement = new Date($requete1[0] + 60000); //On définit la variable de l'heure de fin de préparation de commande
var total_secondes = (date_evenement - date_actuelle) / 1000; //On divise par 1000 car la date est en millisecondes

var prefixe = "Votre commande sera prête dans environ ";
if (total_secondes < 0)
{
    prefixe = "Commande normalement prête depuis "; // On modifie le préfixe si la différence est négatif
    total_secondes = Math.abs(total_secondes); // On ne garde que la valeur absolue
}

if (total_secondes > 0)
{
        var jours = Math.floor(total_secondes / (60 * 60 * 24));
        var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
        minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
        secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));

        var et = "et";
        var mot_jour = "jours,";
        var mot_heure = "heures,";
        var mot_minute = "minutes,";
        var mot_seconde = "secondes";

        if (jours == 0)
        {
            jours = '';
            mot_jour = '';
        }
        else if (jours == 1)
        {
            mot_jour = "jour,";
        }

        if (heures == 0)
        {
            heures = '';
            mot_heure = '';
        }
        else if (heures == 1)
        {
            mot_heure = "heure,";
        }

        if (minutes == 0)
        {
            minutes = '';
            mot_minute = '';
        }
        else if (minutes == 1)
        {
            mot_minute = "minute,";
        }

        if (secondes == 0)
        {
            secondes = '';
            mot_seconde = '';
            et = '';
        }
        else if (secondes == 1)
        {
            mot_seconde = "seconde";
        }

        if (minutes == 0 && heures == 0 && jours == 0)
        {
            et = "";
        }

        compte_a_rebours.innerHTML = prefixe + jours + ' ' + mot_jour + ' ' + heures + ' ' + mot_heure + ' ' + minutes + ' ' + mot_minute + ' ' + et + ' ' + secondes + ' ' + mot_seconde;
    }
    else
    {
        compte_a_rebours.innerHTML = 'Compte à rebours terminé.';
    }

    var actualisation = setTimeout("compte_a_rebours();", 1000);
}
compte_a_rebours();
 
</script>


?>