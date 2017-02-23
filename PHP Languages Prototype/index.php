<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
            
            if(!isset($_GET["lang"])){
               $lang = "en"; 
            }else{
                $lang = $_GET["lang"];
            }
        
            if(isset($_POST['fr']) || $lang == "fr") {
                $lang = "fr";
                print('<link rel="stylesheet" href="css/stylesFR.css">');
            }else if(isset($_POST['du']) || $lang == "du") {
                $lang = "du";
                print('<link rel="stylesheet" href="css/stylesDU.css">');
            }else if(isset($_POST['es']) || $lang == "es") {
                $lang = "es";
                print('<link rel="stylesheet" href="css/stylesES.css">');
            }else{
                print('<link rel="stylesheet" href="css/stylesEN.css">');
            }
        ?>
        <link href='http://fonts.googleapis.com/css?family=Carrois Gothic SC' rel='stylesheet'>
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <title>PaperCheck</title>
    </head>
    <body>
        
        <?php
           switch($lang){
                case "en":
                    $websiteName = "PaperCheck";
                    $subLine = "The Online Academic Paper Peer Review Service";
                    $enterID = "Enter User ID";
                    $enterPassword = "Enter Password";
                    $signUpButton = "Create Account";
                    $loginButton = "LOGIN";
                    $forgotLink = "Forgot Password?";
                break;
                    
                case "fr":
                    $websiteName = "Vérification Du Papier";
                    $subLine = "Le service d'évaluation par les pairs";
                    $enterID = "Entrez le code d'utilisateur";
                    $enterPassword = "Entrer le mot de passe";
                    $signUpButton = "Créer un compte";
                    $loginButton = "s'identifier";
                    $forgotLink = "Mot de passe oublié?";
                break;
                    
                case "du":
                    $websiteName = "Papierprüfung";
                    $subLine = "Die Online-Academic Paper Peer-Review-Service.";
                    $enterID = "Geben Sie die Benutzer-ID ein";
                    $enterPassword = "Passwort eingeben";
                    $signUpButton = "Benutzerkonto anlegen";
                    $loginButton = "Anmeldung";
                    $forgotLink = "Passwort vergessen?";
                break;
                    
                case "es":
                    $websiteName = "Cheque De Papel";
                    $subLine = "El Servicio de Revisión por Pares de Documentos Académicos en Línea";
                    $enterID = "Ingresar ID De Usuario";
                    $enterPassword = "Introducir La Contraseña";
                    $signUpButton = "Crear Una Cuenta";
                    $loginButton = "Iniciar Sesión";
                    $forgotLink = "¿Se e Olvidó Tu Contraseña?";
                break;
                
            }
          ?>
            <div class = "container">
                <div class="main">
                    <img src= "css/images/LogoTry.png">
                    <?php
                        printf('<p id="websiteName">%s</p>', $websiteName);
                        printf('<p id="subLine">%s</p>', $subLine);
                    ?>
                    <form>
                        <div id="idInput">
                            <?php
                                printf('<input type="text" name="username" placeholder="%s">', $enterID); 
                            ?>
                        </div>
                        <div id="passwordInput">
                            <?php
                                printf('<input type="password" name="password" placeholder="%s">', $enterPassword);
                            ?>
                        </div>
                        <?php
                            printf('<a id="signUpButton" href="signUpPage.php?lang=%s">%s</a>
                            <a class = "loginButton" href="selectionPage.php?lang=%s">%s</a>', $lang, $signUpButton, $lang, $loginButton)
                        ?>
                    </form>
                    <br>
                    <?php
                        printf('<a id="forgotLink" href="forgotPage.php?lang=%s">%s</a>', $lang, $forgotLink)
                    ?>
                </div>
            
                <form action = "index.php" method="post">
                    <input type="submit" class = "languageSelectors" name = "en"
                    value = "English" />
                    <input type="submit" class = "languageSelectors" name = "du"
                    value = "Deutsch" />
                    <input type="submit" class = "languageSelectors" name = "fr"
                    value = "Française" />
                    <input type="submit" class = "languageSelectors" name = "es"
                    value = "Espanôl" />
                </form>
          </div>
       
    </body>
</html>