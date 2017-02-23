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
                    $header = "Hello Kevin,";
                    $subline = "Welcome to PaperCheck. Please make a selection.";
                    $newTask = "Create New Task";
                    $myTask = "My Tasks";
                    $searchTask = "Search Tasks";
                    $settings = "Settings";
                break;
                
                case "du":
                    $header = "Hallo Kevin,";
                    $subline = "Willkommen bei PaperCheck. Bitte treffen Sie eine Auswahl.";
                    $newTask = "Neue Aufgabe erstellen";
                    $myTask = "Meine Aufgaben";
                    $searchTask = "Suchaufgaben";
                    $settings = "Einstellungen";
                break;
                   
                case "fr":
                    $header = "Bonjour Kevin,";
                    $subline = "Bienvenue chez PaperCheck. Veuillez faire une sélection.";
                    $newTask = "Créer une nouvelle tâche";
                    $myTask = "Mes tâches";
                    $searchTask = "Tâches de recherche";
                    $settings = "Paramètres";
                break;
                   
                case "es":
                    $header = "Hola Kevin,";
                    $subline = "Bienvenido a PaperCheck. Por favor haz una selección.";
                    $newTask = "Crear nueva tarea";
                    $myTask = "Mis tareas";
                    $searchTask = "Tareas de búsqueda";
                    $settings = "Ajustes";
                break;
                
           }
        ?>
        <div id="selectionContainer">
            <img id="selectionLogo" src= "css/images/LogoTry.png">
            <?php
                printf('<p id="selectionHeader">%s</p><p id="selectionSub">%s</p>', $header, $subline);
            ?>
            <div class="selections">
                <img class = "selectionImages" src= "css/images/AddLogo.png">
                <?php
                    printf('<p class = "selectionText">%s</p>', $newTask);
                ?>
            </div>
            <div class="selections">
                <img class = "selectionImages" src= "css/images/tasksLogo.png">
                <?php
                    printf('<p class = "selectionText">%s</p>', $myTask);
                ?>
            </div>
            <div class="selections">
                <img class = "selectionImages" src= "css/images/searchLogo.png">
                <?php
                    printf('<p class = "selectionText">%s</p>', $searchTask);
                ?>
            </div>
            <div class="selections">
                <img class = "selectionImages" src= "css/images/SettingsLogo.png">
                <?php
                    printf('<p class = "selectionText">%s</p>', $settings);
                ?>
            </div>
        </div>
    </body>
</html>