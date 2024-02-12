<?php





header('Content-Type: application/json'); // Assurez-vous que la réponse est de type application/json



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
    }
}




// Fonction pour envoyer la requête avec le choix sélectionné à l'API OpenAI

// Inclure la fonction sendChoiceRequest ou placer le contenu de la fonction ici

// Récupérer les valeurs envoyées depuis le client
$selectedChoice = $_POST['choice'];
$threadId = $_POST['threadId'];

// Appeler la fonction sendChoiceRequest avec les données obtenues


// Définition des données à envoyer
$postData = [
    'role' => 'user',
    'content' => $selectedChoice
];

// Initialisation de la session cURL
$curl = curl_init();

// Configuration de la requête cURL
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/threads/" . $threadId . "/messages?",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($postData),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $newOpenAIKey",
        "Content-Type: application/json",
        "OpenAI-Beta: assistants=v1"
    ],
    CURLOPT_SSL_VERIFYPEER => false // Disable SSL verification

]);

// Exécution de la requête cURL
$response = curl_exec($curl);
$err = curl_error($curl);

// Fermeture de la session cURL
curl_close($curl);

// Gestion des erreurs et traitement de la réponse
if ($err) {
} else {
    // Autres traitements en fonction de la réponse
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
} else {
}

sleep(8);

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
} else {
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
} else {
}

$output = [
    'textSansChoix' => $textSansChoix,
    'choix1' => $choix1,
    'choix2' => $choix2,
    'choix3' => $choix3
];

// Convertir les données en JSON
echo json_encode($output);
