<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Carrois Gothic SC' rel='stylesheet'>
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <title>PaperCheck</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
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
                    $signUpContent = "Please fill in the fields to create an account.";
                    $firstNameText = "Enter First Name";
                    $surameText = "Enter Surname";
                    $emailText = "Enter E-Mail Address";
                    $passwordText = "Enter Password";
                    $repasswordText = "Re-Enter Password";
                    $createAccount = "Create Account";
                    $returnButton = "Return To Login";
                    $passwordTooShort = "Password needs to be at least 8 characters long.";
                    $passwordNoNumbers = "Password needs to have at least one number.";
                    $passwordNoLetters = "Password needs to have at least one letter.";
                break;
                   
                case "du":
                    $signUpContent = "Bitte füllen Sie die Felder aus, um ein Konto zu erstellen.";
                    $firstNameText = "Bitte Vornamen eingeben";
                    $surameText = "Nachname eingeben";
                    $emailText = "E-Mail Adresse eingeben";
                    $passwordText = "Passwort eingeben";
                    $repasswordText = "Kennwort erneut eingeben";
                    $createAccount = "Benutzerkonto Anlegen";
                    $returnButton = "Zurück zur Anmeldung";
                break;
                   
                case "fr":
                    $signUpContent = "Veuillez remplir les champs pour créer un compte.";
                    $firstNameText = "Entrez votre prénom";
                    $surameText = "Saisir votre nom";
                    $emailText = "Entrer l'adresse e-mail";
                    $passwordText = "Entrer le mot de passe";
                    $repasswordText = "Retaper le mot de passe";
                    $createAccount = "Créer un compte";
                    $returnButton = "Retour à la page d'accueil";
                break;
                   
                case "es":
                    $signUpContent = "Por favor, rellene los campos para crear una cuenta.";
                    $firstNameText = "Introducir nombre";
                    $surameText = "Ingrese su apellido";
                    $emailText = "Introducir la dirección de correo electrónico";
                    $passwordText = "Introducir la contraseña";
                    $repasswordText = "Escriba la contraseña otra vez";
                    $createAccount = "Crear una cuenta";
                    $returnButton = "Volver a inicio de sesión";
                break;
           }
          ?>
        <div id="signUpMain">
            <img src= "css/images/LogoTry.png">
            <div id="signUpTextContainer">
                <?php
                    printf('<p class="signUpContent">%s</p>', $signUpContent);
                ?>
            </div>
            <form action = "signUpPage.php?lang=$lang" method="post">
                
                <div id="firstNameInput">
                    <?php
                        printf('<input type="text" name="firstName" placeholder="%s">', $firstNameText);
                    ?>
                </div>               
                <div id="surnameInput">
                    <?php
                        printf('<input type="text" name="surname" placeholder="%s">', $surameText);
                    ?>
                </div>
                <div id="emailInput">
                    <?php
                        printf('<input type="text" name="email" placeholder="%s">', $emailText);
                    ?>
                </div>
                <div id="passwordSignUpInput">
                    <?php
                        printf('<input type="password" name="password1" placeholder="%s">', $passwordText);
                        if(isset($_POST['password'])){
                            $password = htmlentities($_POST['password']);
                            $passwordOK = true;
                            $counter = 4;
                            if(strlen($password) < 8){
                                $counter--;
                                $passwordOK = false;
                                printf('<p class = passwordWeakness>%s</p><br>', $passwordTooShort);
                            }
                            if (!preg_match("#[0-9]+#", $password)) {
                                $counter--;
                                $passwordOK = false;
                                printf('<p class = passwordWeakness>%s</p><br>', $passwordNoNumbers);   
                            }
                            if (!preg_match("#[a-zA-Z]+#", $password)) {
                                $counter--;
                                $passwordOK = false;
                                printf('<p class = passwordWeakness>%s</p><br>', $passwordNoLetters); 
                            }
                        }
                    ?>
                </div>
                <div id="checkPasswordSignUpInput">
                    <?php
                        printf('<input type="password" name="passwordCheck" placeholder="%s">', $repasswordText);
                    ?>
                </div>
                <div class="g-recaptcha" data-sitekey="6Lf3TBUUAAAAAMDeQb26h34DE0BWo4ZdY7BT2bDy"></div>
                <?php              
                    printf('<input type="submit" name="submit" value="%s" class = "loginButton">', $createAccount);
                ?>
                <br>
                
            </form>
            <br>
            <?php
                printf('<a id="returnButtonSignUpPage" href="index.php?lang=%s">%s</a>', $lang, $returnButton);
            ?>
        </div>
    </body>
</html>