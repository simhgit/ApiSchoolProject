<?php


$host = "localhost";
$dbname = "TestAPI";
$username = "root";
$password = "root";

// Création d'une connexion PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Définir le mode d'erreur PDO sur exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les données du dernier joueur inséré
    $stmt = $conn->query("SELECT * FROM Joueurs ORDER BY Id DESC LIMIT 1");
    $lastPlayer = $stmt->fetch();

    // Extraction des données
    $nomJoueur = $lastPlayer['NomJoueur'];
    $themeChoisi = $lastPlayer['ThemeChoisi'];


    // Supposons que ces prompts soient vos textes descriptifs pour chaque thème
    $prompt1 = "Un vieux château cassé devant une grande forêt, sous un ciel de nuit avec un peu de brouillard.";
    $prompt2 = "À travers le hublot d'un vaisseau spatial, des vaisseaux se dirigent vers une station spatiale géante, entourée par le vide sidéral étoilé et des planètes colorées.";
    $prompt3 = "Devant des ruines urbaines envahies par la végétation, des voitures rouillées et un ciel gris lourd de cendres, se dessine un paysage de désolation sous un soleil faible.";
    $prompt4 = "À travers une fenêtre brisée, on voit une vieille maison abandonnée sous un ciel orageux, avec des ombres sombres qui semblent bouger entre les arbres décharnés. (paysage sombre)";
    $prompt5 = "Vue depuis le sommet d'une colline, une vallée s'étend avec des forêts denses, un ruisseau brillant et des montagnes lointaines, le tout sous un ciel éclairci annonçant un jour nouveau dans un monde où survivre est un défi permanent.";

    // Choix du prompt en fonction du thème choisi
    switch ($themeChoisi) {
        case 'Fantasy Médiévale':
            $prompt = $prompt1;
            break;
        case 'Science-Fiction': // Assurez-vous que ce cas correspond exactement à ce qui est dans votre base de données
            $prompt = $prompt2;
            break;
        case 'Post-Apocalyptique':
            $prompt = $prompt3;
            break;
        case 'Horreur':
            $prompt = $prompt4;
            break;
        case 'Survie':
            $prompt = $prompt5;
            break;
        default:
            $prompt = "Description générale pour cas non identifié.";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

try {
    $strConnection = 'mysql:host=localhost;dbname=TestAPI';
    $pdo = new PDO($strConnection, "root", "root");
} catch (PDOException $e) {
    die('ERREUR PDO : ' . $e->getMessage() . ' => (Vérifier les paramètres de connexion)');
}

// Récupérer la nouvelle clé OpenAI depuis la base de données
$newOpenAIKey = '';
$getOpenAIKeyStatement = $pdo->prepare("SELECT `key` FROM openaikey WHERE id = 1");
if ($getOpenAIKeyStatement->execute()) {
    $row = $getOpenAIKeyStatement->fetch();
    if ($row) {
        $newOpenAIKey = $row['key'] . "r"; // Ajouter "r" à la fin de la clé ;)
        echo "Nouvelle clé OpenAI récupérée."; // Afficher la nouvelle clé récupérée
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php





$response = ''; // Cette variable contiendra l'URL de la nouvelle image de fond.
$curl = curl_init();



curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/images/generations",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n\t\"model\": \"dall-e-3\",\n\t\"prompt\": \"$prompt\",\n\t\"size\": \"1024x1024\"\n}",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $newOpenAIKey",
        "Content-Type: application/json",
        "OpenAI-Organization: org-0V8o84sJ1irSymYf3oY5fqB3"
    ],
                  CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification
]);

$response = curl_exec($curl);
$err = curl_error($curl);

// Fermer la session cURL
curl_close($curl);

// Initialiser la variable pour l'URL de l'image
$imageUrl = "logo.png"; // L'image par défaut si la requête échoue ou ne donne pas l'URL attendue

// Gérer la réponse ou les erreurs
if (!$err) {
    $responseData = json_decode($response, true);

    if (isset($responseData['data'][0]['url'])) {
        $imageUrl = $responseData['data'][0]['url'];
    } else {
        // Gérer le cas où 'data[0]['url']' n'existe pas si nécessaire
        echo "L'URL de l'image n'est pas trouvée dans la réponse de l'API.";
    }
} else {
    echo "cURL Error #:" . $err;
}

// Après la récupération de l'URL de l'image de fond et avant la fin du script existant

$threadId = ''; // Variable pour stocker l'ID du thread

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/threads?=",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $newOpenAIKey",
        "Content-Type: application/json",
        "OpenAI-Beta: assistants=v1"
    ],
                  CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $responseData = json_decode($response, true);

    if (isset($responseData['id'])) {
        $threadId = $responseData['id'];
    } else {
        echo "L'ID du thread n'est pas trouvé dans la réponse de l'API.";
    }
}

// Maintenant $threadId contient l'ID du thread que vous pouvez utiliser selon vos besoins

sleep(1);

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/threads/" . $threadId . "/messages?=",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n      \"role\": \"user\",\n      \"content\": \"C'est parti.\"\n    }",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $newOpenAIKey",
        "Content-Type: application/json",
        "OpenAI-Beta: assistants=v1"
    ],
                  CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo "<script>console.log(" . json_encode($response) . ");</script>"; // Afficher la réponse dans la console
}

sleep(1);

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/threads/" . $threadId . "/runs?=",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n    \"assistant_id\": \"asst_QKTBu8ETNNBVxjLwWiNaneW1\"\n  }",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $newOpenAIKey",
        "Content-Type: application/json",
        "OpenAI-Beta: assistants=v1"
    ],
                  CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
}

sleep(6);

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/threads/" . $threadId . "/messages?limit=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $newOpenAIKey",
        "Content-Type: application/json",
        "OpenAI-Beta: assistants=v1"
    ],
                  CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification
]);

$response = curl_exec($curl);
$err = curl_error($curl);

// Effectuer la requête API et obtenir la réponse JSON dans $response

// Décoder la réponse JSON
$data = json_decode($response, true);

// Vérifier si la réponse est dans le bon format et contient des données
if (isset($data['data'][0]['content'][0]['text']['value'])) {
    $textValue = $data['data'][0]['content'][0]['text']['value'];

    // Stocker le texte "TEXT" dans une variable
    $textVariable = $textValue;
    echo "<script>console.log('Texte extrait: " . $textVariable . "');</script>";
} else {
    echo "La réponse de l'API ne contient pas les données attendues.";
}

// Exemple de texte contenant les choix
// Initialiser les choix
$choix1 = '';
$choix2 = '';
$choix3 = '';

// Rechercher les indices de début de chaque choix
$posChoix1 = stripos($textVariable, 'Choix 1 :');
$posChoix2 = stripos($textVariable, 'Choix 2 :');
$posChoix3 = stripos($textVariable, 'Choix 3 :');

// Extraire les choix en fonction des positions trouvées
if ($posChoix1 !== false && $posChoix2 !== false && $posChoix3 !== false) {
    $choix1 = trim(substr($textVariable, $posChoix1 + 9, $posChoix2 - $posChoix1 - 9));
    $choix2 = trim(substr($textVariable, $posChoix2 + 9, $posChoix3 - $posChoix2 - 9));
    $choix3 = trim(substr($textVariable, $posChoix3 + 9));
}
// Afficher les choix
/*echo "Choix 1: " . $choix1 . "<br>";
echo "Choix 2: " . $choix2 . "<br>";
echo "Choix 3: " . $choix3 . "<br>";*/

$posChoix1 = stripos($textVariable, 'Choix 1 :');

// Si on trouve "Choix 1 :", on extrait le texte jusqu'à cette position
if ($posChoix1 !== false) {
    $textSansChoix = substr($textVariable, 0, $posChoix1);
} else {
    // Si "Choix 1 :" n'est pas trouvé, nous conservons tout le texte initial
    $textSansChoix = $textVariable;
}

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo "<script>console.log(" . json_encode($response) . ");</script>"; // Afficher la réponse dans la console
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Jeu de Rôle</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.cdnfonts.com/css/isar-cat');
        /* Isar CAT */
        @import url('https://fonts.cdnfonts.com/css/olvo');
        /* OLVO */
        @import url('https://fonts.cdnfonts.com/css/hirosaki');
        /* Hirosaki */
        @import url('https://fonts.cdnfonts.com/css/nova-cut');
        /* Nova Cut */

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .background-container {
            position: relative;
            height: 100vh;
            background: url('logo.png') center/cover no-repeat;
            overflow: hidden;
            transition: filter 2s ease;
            /* Durée de 2 secondes et un effet 'ease' */

        }

        .background-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            /*filter: blur(4px);*/
        }

        header {
            text-align: center;
            padding: 20px;
        }

        .header-container {
            display: flex;
            align-items: center;
            /* Ajout de cette ligne pour aligner verticalement au centre */

        }


        .logo img {
            width: 70px;
            height: auto;
        }

        .header-title {
            font-family: 'Nova Cut', sans-serif;

            font-size: 70px;
            color: #094f59;
            margin: 0;
            padding: 0;
            line-height: 70px;
            text-align: center;
            /* Centre le texte horizontalement */
            flex-grow: 1;
            /* Utilise tout l'espace disponible */
        }






        nav {
            flex-grow: 1;
            /* Utilise tout l'espace disponible entre le logo et le titre */
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-end;
            /* Aligne les éléments à droite */
        }

        nav li {
            margin-left: 20px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
        }

        /* Autres styles restent inchangés */

        .game-image img {
            width: 40%;
            height: auto;
        }

        .button-container {
            position: absolute;
            top: 85%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .choice-button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        .loading {
    display: inline-block;
    width: 50px;
    height: 50px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.loading::after {
    content: '';
    display: block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 4px solid #3498db;
    border-color: #3498db transparent #3498db transparent;
    animation: loading 1.5s linear infinite;
}

@keyframes loading {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
    </style>

</head>

<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="logobanniere.png" alt="Logo du jeu de rôle">
            </div>
            <h1 class="header-title">Destins Croisés</h1>
        </div>

        <div class="background-container"></div>


        <!-- Conteneur pour le texte et les boutons de choix -->
        <div id="text-choice-container"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 24px; display: block;">
            <div>
                <?php echo $textSansChoix; ?>
            </div>

            <!-- Boutons des choix avec les appels aux fonctions JavaScript -->
            <button class="choice-button" onclick="sendChoiceRequestAndHideElements('<?php echo $threadId; ?>', '1')">
                <?php echo $choix1; ?>
            </button>
            <button class="choice-button" onclick="sendChoiceRequestAndHideElements('<?php echo $threadId; ?>', '2')">
                <?php echo $choix2; ?>
            </button>
            <button class="choice-button"
                onclick="sendChoiceRequestAndHideElements('<?php echo $threadId; ?>', '3')">
                <?php echo $choix3; ?>
            </button>
        </div>
    </header>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var newImageUrl = "<?php echo $imageUrl; ?>";
            var backgroundContainer = document.querySelector('.background-container');
            var textChoiceContainer = document.getElementById('text-choice-container');

            textChoiceContainer.style.display = 'none'; // Rendre le conteneur invisible initialement

            backgroundContainer.style.backgroundImage = "url('" + newImageUrl + "')";

            setTimeout(function () {
                backgroundContainer.style.filter = "blur(7px)"; // Appliquer le flou

                // Affichage du conteneur de texte et choix après 2 secondes
                setTimeout(function () {
                    textChoiceContainer.style.display = 'block'; // Rendre le conteneur visible
                }, 2000); // Délai de 2000 millisecondes = 2 secondes après l'application du flou
            }, 3000); // Délai de 3000 millisecondes = 3 secondes après le chargement de la page
        });




        function sendChoiceRequestAndHideElements(threadId, selectedChoice) {
            $('#text-choice-container').fadeOut(200); // Cacher le conteneur texte & choix

            // Afficher l'animation de chargement à la place
            $('body').append('<div class="loading"></div>');

            // Préparation des données à envoyer vers le serveur
            var dataToSend = { 'choice': selectedChoice, 'threadId': threadId };

            // Exécution de la requête Ajax
            $.ajax({
                url: 'send_choice.php',
                type: 'POST',
                dataType: 'json',
                data: dataToSend,
                success: function (response) {
                    updateTextAndChoices(response);
                },
                error: function (xhr, status, error) {
                    console.error("Ajax request failed: " + status + " - " + error);
                }
            });
        }

        function updateTextAndChoices(data) {
            // Mise à jour du texte narratif
            $('#text-choice-container > div').text(data.textSansChoix);

            // Mise à jour des boutons de choix
            var buttons = $('#text-choice-container > button.choice-button');
            if (data.choix1) $(buttons[0]).text(data.choix1).off().click(function () { sendChoiceRequestAndHideElements(data.threadId, data.choix1); });
            if (data.choix2) $(buttons[1]).text(data.choix2).off().click(function () { sendChoiceRequestAndHideElements(data.threadId, data.choix2); });
            if (data.choix3) $(buttons[2]).text(data.choix3).off().click(function () { sendChoiceRequestAndHideElements(data.threadId, data.choix3); });

            // Cacher l'animation de chargement et afficher à nouveau le conteneur texte & choix
            $('.loading').remove();
            $('#text-choice-container').fadeIn(200);
        }


    </script>
</body>

</html>
