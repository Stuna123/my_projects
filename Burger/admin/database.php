<?php
/*
    Connexion à la base de donnée
    Il est composé de 3 termes 
        Le 1er C'est notre serveur qui localhost qui est coller au nom de notre base de donnée noté "dbname" qui est burger
        
        2e partie c'est le login pour notre cas c'est le root
        3e c'est le mot de passe pour notre cas on laisse vide parce qu'il n'y a rien

Le try & catch permet de d'afficher le message d'erreur s'il y'a lieu
    le try teste la partie qui fonctionne
    le catch recupère l'erreur en affichant un message
*/
class Database
{
/*On crée des variables pour rendre la connexion plus simple 
Ces variables n'appartiennent qu'à la classe Database c'pourquoi on le met en privée
*/
    private static $dbHost = "localhost";
    private static $dbName = "webburger";
    private static $dbPort = "3306";
    private static $dbUser = "root";
    private static $dbUserPassword = "";
    
    private static $connection = null;

/*
On crée une fonction pour la connexion qui static parce qu'il appartient à la classe database aussi il ne change pas
*/
    //Si s'était privée au lieu de public, ça bug !
    public static function connect()
    {
        try
        {
            //le mot clé self permet d'acceder à une variable qui est une propriété static
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";port=" . self::$dbPort . ";dbname=" . self::$dbName,self::$dbUser,self::$dbUserPassword);
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }

        return self::$connection;
    }

//On crée une fonction pour la deconnection
    public static function disconnect()
    {
        //Elle annule la connexion
        self::$connection = null;
    }        
}

/*
    Pour appeler une fonction de la classe en étant dehors on utilise "Nom_de_la_classe::Nom_de_la_fonction()"
*/
Database::connect();
?>