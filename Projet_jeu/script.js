//lancement
window.onload = function()
{
    //Creation des variable
    var canvasWidth = 900;
    var canvasHeight = 600;
    var blockSize = 30; // taille des blocs
    
     
    var ctx; //Ceci est un context
    var delay = 200; //milliseconde est notre délai en temps
//    var xCoord = 0;
//    var yCoord = 0;
    var snakee;
    var applee;
    var widthInblocks = canvasWidth/blockSize;
    var heightInblocks = canvasHeight/blockSize;
    var score;
    var timeout;
    
    //On execute la fonction
    init();

    //Fonction standard  qui permet d'initialiser
    function init()
    {
        //On crée un element
        var canvas = document.createElement('canvas');
        canvas.width  = canvasWidth;
        canvas.height = canvasHeight;
        //Bordure
        canvas.style.border  = "30px solid gray";
        
        //marge haut/bas : 50px et gauche/droite : auto 
        canvas.style.margin  = "50px auto";
        
        //Ici on centre un element grace à display block0
        canvas.style.display = "block";
        
        //Couleur de fond
        canvas.style.backgroundColor = "#ddd";
        
        //On attache a notre html
        document.body.appendChild(canvas);
        //Pour dessiner dans le canvas en 2d
        ctx = canvas.getContext('2d');
        
        // x : gauche/droite | y : haut/bas
        snakee = new Snake([[6,4], [5,4], [4,4], [3,4]], "right"); 
        
        //Pomme
        applee = new Apple([10,10]);
        
        //score
        score = 0;
        
        refreshCanvas();
    }

    //Fonction qui permet de rafraichir notre canvas
    function refreshCanvas()
    {
        //On fait l'affection en additionnant de 10
//        xCoord += 10;
//        yCoord += 10;
        
        //On fait avancé le serpent
        snakee.advance();
        
        //On fait condition pour savoir si il y a eu une condition
        if(snakee.checkCollision())
        {
            //Game over
            /*
                alert("Game over. Le serpent se soit mordu ou soit mordu le mur !");
                alert("Veuillez rafraichir la page !");
            */
            gameOver();
        }
        else
        {
            //Si le serpent a manger la pomme
            if(snakee.isEatingApple(applee))
            {
                score++;
                //Ici recoit un bloc de plus si elle mange la pomme
                snakee.ateApple = true;
                /*
                    On fait la repetition du changement de la pomme.
                    Si la pomme est sur le serpent, alors on redonne une autre position.
                    On le fait tant que la pomme sera sur le serpent (snakee).
                    Dans le cas contraire, on change une seule fois la position.
                */
                do
                {
                    //Si cela est vrai, on change des positions
                    applee.setNewDirection();
                }while(applee.isOnSnake(snakee));
                
                if(score%5==0)
                {
                    speedUp();
                }
                
            }
            
            ctx.clearRect(0,0,canvasWidth, canvasHeight);
            //On donne une couleur rouge
    //        ctx.fillStyle = "#FF0000";
            //On crée un rectangle
            /*
                xCoord : distance horizontal
                yCoord : distance verticale
                100 : largeur
                50 : hauteur
            */

    //        ctx.fillRect(xCoord, yCoord, 100, 50);

            //On dessine le score
             drawScore();
            
            //On dessine le serpent
            snakee.draw();

            //On dessine la pomme
            applee.draw();
            
            
            //On execute la fonction après un certain delai passé
            //Notre delay est de 1
            timeout = setTimeout(refreshCanvas,delay);    
        }
        
    }
    
    /*
        Partie solution
    */
    function speedUp()
    {
        delay = delay / 2;
    }
    
    function gameOver()
    {
        ctx.save();
        ctx.font = "bold 60px sans-serif";
        ctx.fillStyle = "yellow";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        
        //Contour
        ctx.strokeStyle = "white";
        ctx.lineWidth = 5;
        
        var centreX = canvasWidth/2;
        var centreY = canvasHeight/2;
        //On remplit le texte avec stroke
        ctx.strokeText("Game Over", centreX, centreY - 180);
        
        //On écrit à l'écran
        ctx.fillText("Game Over", centreX, centreY - 180);
        
        /*
            On affiche le message entre la touche espace entre 0 et game Over
        */
        ctx.font = "bold 30px sans-serif";
        ctx.strokeText("Appuyez sur la touche Espace pour rejouer", centreX, centreY - 120);
        ctx.fillText("Appuyez sur la touche Espace pour rejouer", centreX, centreY - 120);
        
        ctx.restore();
    }
    
    //Fonction permettant de recommencer le jeu
    /*
        La problematique ici est que lorsqu'on recommence, 
        Nous devons aussi gérer la rapidité du jeu
    */
    function restart()
    {
        score = 0;
        snakee = new Snake([[6,4], [5,4], [4,4], [3,4]], "right");
        applee = new Apple([10,10]);
        
        //On remet notre setTimeout comme il était au début du jeu
        //On efface le delay de setTimeout
        clearTimeout(timeout);
        delay = 200;
        refreshCanvas();
    }
    
    function drawScore()
    {
        ctx.save();
        ctx.font = "bold 100px sans-serif";
        
        //Couleur avec laquelle on écrit
        ctx.fillStyle = "gray";
        ctx.textAlign = "center";
        
        //On me au milieu
        ctx.textBaseline = "middle";
        
        /*
            Centre selon les x
        */
        var centreX = canvasWidth/2;
        var centreY = canvasHeight/2;
        
        
        //On écrit à l'écran le score
        ctx.fillText(score.toString(), centreX, centreY);
         
        ctx.restore();
    }
    
    //Cette fonction prend un context et la position d'un bloc
    //Il prends un array dont le 1er elt est le x et le snd y
    function drawBlock(ctx, position)
    {
        //on met la position du bloc
        var x = position[0] * blockSize;
        var y = position[1] * blockSize;
        
        //On rempli selon la largeur et la hauteur pour les bloc
        ctx.fillRect(x,y, blockSize, blockSize);
    }
    
    //Creation du serpent
    //Cette fonction prend en paramètre le corps de notre serpent
    //Cette fonction possède également la direction que peut prendre le serpent
    function Snake(body, direction)
    {
        //corps du serpent
        this.body = body;
        
        //direction du serpent
        this.direction = direction;
        
        //snake eat apple
        this.ateApple = false;
        
        //Ici on dessine le serpent
        this.draw = function()
        {
            /*
                save permet de se souvenir des anciens paramètres qui sont dans le contexte
                
                restore permet de remettre les enregistrements
            */
            
            ctx.save();
            ctx.fillStyle = "#ff0000";
            for(var i = 0; i < this.body.length; i++)
            {
                //On dessine un bloc
                //On lui donne le context sur lequel il va dessiné et la position
                drawBlock(ctx, this.body[i]);         
            }
            ctx.restore();
        };
        //On crée une methode pour faire avancé notre serpent
        this.advance = function()
        {
            //Nouvelle position de la tête
            //On copie l'élément en format copie avec slice
            var nextPosition = this.body[0].slice();
            
            //Direction du serpent
            switch(this.direction)
            {
                    //Ici [0] : x et [1] : y
                    //Le next position ici est le même que le premier elt du tableau dans snakee cad 6
                    case "left":
                        nextPosition[0] -= 1;
                        break;
                    case "right":
                        nextPosition[0] += 1;
                        break;
                    case "down":
                        nextPosition[1] += 1;
                        break;
                    case "up":
                        nextPosition[1] -= 1;
                        break;
                    
                    default:
                        throw("Erreur de direction");
            }
            //On rajoute cette nouvelle position au serpent
            //unshit permet de rajouter son argument
            this.body.unshift(nextPosition);
            
            //Si la pomme a été mangé
            if(!this.ateApple)
            {
                //On supprime également la dernière position
                this.body.pop();
            }
            else
                this.ateApple = false;
        };
        
        //Modification de la direction
        this.setDirection = function(newDirection)
        {
            var allowDirections;
            switch(this.direction)
            {
                case "left":
                case "right":
                    allowDirections = ["up", "down"];
                    break;
                case "down":
                case "up":
                    allowDirections = ["left", "right"];
                    break;
                    
                default:
                    throw("Erreur de direction");
                    
            }
            
            /*
                On fait un teste pour savoir s'il existe des directions
                Parmi les directions qui existent.
                Si le teste est vrai, on donne la direction;
            */
            
            if(allowDirections.indexOf(newDirection) > -1)
            {
                this.direction = newDirection;         
            }
        };
        
        //Methode qui detecte qu'il y a eu collision
        this.checkCollision = function()
        {
            var wallCollision = false;
            var snakeCollision = false;
            
            //tete du serpent
            var head = this.body[0];
            
            //Reste du corps
            var rest = this.body.slice(1);
            var snakeX = head[0];
            var snakeY = head[1];
            
            //Cadre de notre grille pour le serpent
            var minX = 0;
            var minY = 0;
            var max_X = widthInblocks - 1;
            var max_Y = heightInblocks - 1;
            
            //On verifie si la tête se prit au mur de manière horizontal
            var isNotBetweenHorizontalWalls = snakeX < minX || snakeX > max_X;
            
            //On verifie si la tête se prit au mur de manière vertical
            var isNotBetweenVerticalWalls = snakeY < minY || snakeY > max_Y;
            
            //Verification que le serpent se prit un mur
            if(isNotBetweenHorizontalWalls || isNotBetweenVerticalWalls)
            {
                wallCollision = true;
            }
            
            //On verifie si la tête est passé sur son propre corps
            for(var i = 0; i < rest.length; i++)
            {
                //On verifie si la tête du serpent et le reste du corps on le même corps X etY
                if(snakeX === rest[i][0] && snakeY === rest[i][1])
                {
                    //Si la tête du serpent est sur le reste du corps
                    snakeCollision = true;
                }
            }
            
            //On retourne une collision soit sur le mur ou sur la tête du serpent
            return wallCollision || snakeCollision;
        };
        
        //Methode pour manger la pomme, prends en paramètre une position
        this.isEatingApple = function(appleToEat)
        {
            //On crée la tête du serpent qui le corps à la place 0
            var head = this.body[0];
            
            //On verifie si la tête du serpent a toucher la pomme
            if(head[0] === appleToEat.position[0] && head[1] === appleToEat.position[1])
            {
                return true;
            }
            else
                return false;
        };
    }
    
    /*
        Creation de la pomme, elle a besoin d'une position
    */
    function Apple(position)
    {
        this.position = position;
        
        /*
            Fonction qui permet de dessiner
        */
        this.draw = function()
        {
            ctx.save();
            
            //Couleur bleu de ce qui sera remplit
            ctx.fillStyle = "#0000FF";
            
            //Permet de commencer un debut lors du tracage
            ctx.beginPath();
            var rayon = blockSize/2;
            
            //Mettre ici this.position pour que la pomme soit mis à jour
            //Sans cela rien ne pourra se passer lorsque qu'on dessiner la pomme
            var x = this.position[0]*blockSize + rayon;
            var y = this.position[1]*blockSize + rayon;
            
            //fonction permettant de dessiner un cercle et arc de cercle
            ctx.arc(x, y, rayon, 0, Math.PI*2, true);
            
            //On remplit la pomme
            ctx.fill();
            ctx.restore();            
        };
        
        //On deplace la pomme après que le serpent a eu à la manger
        this.setNewDirection = function()
        {
            //On crée une nouvelle variable de X
            //On lui donne valeur aleatoire arrondi
            //Même chose pour Y
            var newX = Math.round(Math.random() * (widthInblocks-1));
            var newY = Math.round(Math.random() * (heightInblocks - 1));
            
            //On lui donne une nouvelle position
            this.position = [newX, newY];
        };
        
        this.isOnSnake = function(snakeToCheck)
        {  
            //On n'pas sur le serpent
            var isOnSnake = false;
            
            //On parcour tous les blocs du serpent
            for(var i = 0; i < snakeToCheck.body.length; i++)
            {
                //On verifie si la pomme est sur le serpent
                if( (this.position[0] === snakeToCheck.body[i][0]) && (this.position[1] === snakeToCheck.body[i][1]) )
                {
                    isOnSnake = true;
                }
            }
            
            return isOnSnake; 
        };
    }
    
    //Quand l'utilsateur appuis sur une
    document.onkeydown = function handleKeyDown(e)
    {
        var key = e.keyCode;
        var newDirection;
        
        //Choix de la touche qui a été appuyé par l'utilisateur
        switch(key)
        {
            case 37:
                newDirection = "left";
                break;
            
            case 38:
                newDirection = "up";
                break;
            
            case 39:
                newDirection = "right";
                break;
            
            case 40:
                newDirection = "down";
                break;           
            
            //Touche espace    
            case 32:
                restart();
                return;
            
            default:
                return;
        }
        snakee.setDirection(newDirection);
    }
}
