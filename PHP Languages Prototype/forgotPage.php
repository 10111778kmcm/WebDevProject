<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Carrois Gothic SC' rel='stylesheet'>
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <title>PaperCheck</title>
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
    </head>
    <body>
        <?php
           switch($lang){
                case "en":
                    $forgotContent = "Please enter you e-mail address associated with your account and we will contact you with your password.";
                    $emailEntry = "Enter E-Mail Address";
                    $sendButton = "SEND";
                    $returnButton = "Return To Login";
                break;
                
                case "fr":
                    $forgotContent = "Ingrese su dirección de correo electrónico asociada a su cuenta y nos pondremos en contacto con usted con su contraseña.";
                    $emailEntry = "Introducir la dirección de correo electrónico";
                    $sendButton = "ENVIAR";
                    $returnButton = "Volver a inicio de sesión";
                break;
                
                case "du":
                    $forgotContent = "Bitte geben Sie Ihre E-Mail-Adresse ein, die mit Ihrem Konto verknüpft ist. Wir werden Sie dann mit Ihrem Passwort kontaktieren.";
                    $emailEntry = "E-Mail Adresse eingeben";
                    $sendButton = "SENDEN";
                    $returnButton = "Zurück zur Anmeldung";
                break;
                   
                case "es":
                    $forgotContent = "Ingrese su dirección de correo electrónico asociada a su cuenta y nos pondremos en contacto con usted con su contraseña.";
                    $emailEntry = "Introducir la dirección de correo electrónico";
                    $sendButton = "ENVIAR";
                    $returnButton = "Volver a inicio de sesión";
                break;
           }
        ?>
        <div class="main">
            <img src= "css/images/LogoTry.png">
            <?php
                printf('<p id="forgotContent">%s</p>', $forgotContent);
            ?>
            <form>
                <div id="forgotEmailInput"> 
                    <?php
                        printf('<input type="text" name="email" placeholder="%s">', $emailEntry);
                    ?>
                </div>
                <?php
                    printf('<input type="submit" name="submit" value="%s" id = "sendButton">
                    <br>
                    <a id= returnButton href="index.php?lang=%s">%s</a>', $sendButton, $lang, $returnButton);
                ?>
            </form>
        </div>
    </body>
</html>