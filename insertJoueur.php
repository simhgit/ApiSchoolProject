<?php
try {
    $strConnection = 'mysql:host=localhost;dbname=TestAPI';
    $pdo = new PDO($strConnection, "root", "root");
} catch (PDOException $e) {
    die('ERREUR PDO : ' . $e->getMessage() . ' => (Vérifier les paramètres de connexion)');
}

// Votre connexion PDO ici...
$pdo = new PDO('mysql:host=localhost;dbname=TestAPI', 'root', 'root');

$nomJoueur = $_POST['nomJoueur'];
$themeChoisi = $_POST['themeChoisi'];

$insertStatement = $pdo->prepare("INSERT INTO Joueurs (NomJoueur, ThemeChoisi) VALUES (:nomJoueur, :themeChoisi)");
$insertStatement->bindParam(':nomJoueur', $nomJoueur);
$insertStatement->bindParam(':themeChoisi', $themeChoisi);

if ($insertStatement->execute()) {
    echo "Joueur ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout du joueur.";
}
?>