<!DOCTYPE html>
    <html>
            <head>
                    <title>Connection</title>
                    <meta charset="utf-8" />
             </head>

             <body>
                    <?php
                    
                    include_once("./classe/DB_User.php");
                    include_once("./classe/DB.php");

                        if (isset($_POST["login"]) && isset($_POST["mdp"])){
                            $db = new DB_User;

                            //on test les identifiants de connexion
                            if ($db->checkId($_POST["login"],$_POST["mdp"])){
                                echo("Vous êtes connecté !");
                            }
                            else{

                                echo("Identifiants incorrect !");
                            }
                        }
                    ?>
                    <form action="identification.php" method="post">
                         <p>Votre Login : <input type="text" name="login" /></p>
                         <p>Votre MdP : <input type="text" name="mdp" /></p>
                         <p><input type="submit" value="Connection"></p>
                    </form>
                
             </body>
     </html>