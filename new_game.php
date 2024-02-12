<!DOCTYPE html>
<html lang="fr">


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
        }

        .background-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(4px);
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

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .input-container {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: top 1s ease, visibility 0.5s ease;
            visibility: hidden;
        }

        .input-container.visible {
            top: 400px;
            visibility: visible;
        }

        .input-container.hide {
            top: 150%;
            visibility: hidden;
        }

        /* Nouveaux styles pour le message de bienvenue */
        .welcome-message-container {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: top 1.5s ease, visibility 0.5s ease;
            visibility: hidden;
            white-space: nowrap;
            /* Empêche le texte de se retourner à la ligne */
            overflow: hidden;
            /* Cache le texte qui dépasse la largeur de la boîte */
            text-overflow: ellipsis;
            /* Affiche des points de suspension pour indiquer du texte masqué */
        }

        .welcome-message-container.visible {
            top: 200px;
            visibility: visible;
        }

        .welcome-message-container.hide {
            top: 150%;
            visibility: hidden;
        }

        /* Nouveaux styles pour les propositions de thème */
        .theme-proposal-container {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: top 1.5s ease, visibility 0.5s ease;
            visibility: hidden;
        }

        .theme-proposal-container.visible {
            top: 300px;
            visibility: visible;
        }

        .theme-button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #000000;
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .theme-button:hover {
            background-color: #0056b3;
        }

        .theme-proposal-container.hide {
            top: 150%;
            visibility: hidden;
        }


        .theme-welcome-container {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: top 1s ease, visibility 0.5s ease;
            visibility: hidden;
            white-space: nowrap;
            /* Empêche le texte de se retourner à la ligne */
            overflow: hidden;
            /* Cache le texte qui dépasse la largeur de la boîte */
            text-overflow: ellipsis;
            /* Affiche des points de suspension pour indiquer du texte masqué */
        }

        .theme-welcome-container.visible {
            top: 200px;
            /* Changer la position finale pour qu'il s'affiche à la bonne hauteur */
            visibility: visible;
        }

        .theme-welcome-container.hide {
            top: 150%;
            /* Changer la position de sortie */
            visibility: hidden;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var inputContainer = document.querySelector(".input-container");
            var inputBox = document.querySelector(".input-container input");
            var submitButton = document.querySelector(".input-container button");
            var welcomeMessageContainer = document.querySelector(".welcome-message-container");
            var themeProposalContainer = document.querySelector(".theme-proposal-container");
            var themeWelcomeContainer = document.querySelector(".theme-welcome-container");
            // Fonction pour afficher la boîte de saisie
            function showInputBox() {
                inputContainer.classList.add("visible");
            }

            // Fonction pour réagir au clic sur le bouton de validation
            function handleSubmit() {
                var pseudo = inputBox.value;
                console.log(pseudo);
                inputContainer.classList.add("hide"); // Ajouter la classe pour l'animation de sortie
                setTimeout(function () {
                    inputContainer.classList.remove("visible", "hide");
                    showWelcomeMessage(pseudo);
                }, 500); // Délai correspondant à la durée de l'animation (500ms)
            }

            // Fonction pour afficher le message de bienvenue
            function showWelcomeMessage(pseudo) {
                welcomeMessageContainer.querySelector("#pseudo").textContent = pseudo; // Injecter le pseudo dans le message
                welcomeMessageContainer.classList.add("visible");
                setTimeout(function () {
                    showThemeProposals();
                }, 1000); // Délai d'affichage des propositions de thème (1000ms)
            }

            // Fonction pour afficher le message de bienvenue
            function showWelcomeThemeMessage(chosenTheme) {
                themeWelcomeContainer.querySelector("#theme").textContent = chosenTheme; // Injecter le thème dans le message
                themeWelcomeContainer.classList.add("visible");
                setTimeout(function () {
                    themeWelcomeContainer.classList.add("hide");
                    // Attendre la fin de l'animation de sortie
                    setTimeout(function () {
                        var pseudo = document.getElementById("pseudo").textContent;
                        var themeChoisi = document.getElementById("theme").textContent;

                        // Appel de la fonction pour insérer les données dans la base de données
                        insertJoueur(pseudo, themeChoisi);

                        // Continuer avec l'animation ou le reste de votre code
                        zoomIntoMiddleOfPage();
                    }, 500); // Ajouter un délai supplémentaire si nécessaire pour la fin de l'animation de sortie
                }, 2000); // Le délai avant que l'animation de sortie ne commence
                setTimeout(function () {
                    zoomIntoMiddleOfPage();
                }, 2500); // Durée de l'animation de sortie + un petit tampon, ajustez en fonction de votre animation exacte
            }

            function zoomIntoMiddleOfPage() {
                document.body.style.transition = "transform 15s ease-in-out";
                document.body.style.transform = "scale(160)";
                document.body.style.transformOrigin = "50.15% 62%";

                // Attendre la fin de l'animation de zoom, puis rendre la page blanche
                // Redirection vers la nouvelle page HTML après une courte période pour permettre à l'animation du fond de se terminer
                setTimeout(function () {
                    window.location.href = 'start_game_test.php'; // Changer l'emplacement de la fenêtre actuelle par la nouvelle URL
                }, 100); // Ce délai est ajustable selon le besoin
            }




            // Fonction pour afficher les propositions de thème
            function showThemeProposals() {
                themeProposalContainer.classList.add("visible");
            }


            submitButton.addEventListener("click", handleSubmit);
            window.addEventListener("load", showInputBox);

            // Capturer le clic sur un bouton de thème
            document.querySelectorAll('.theme-button').forEach(button => {
                button.addEventListener('click', function () {
                    // Récupérer le texte du bouton de thème choisi
                    const chosenTheme = this.textContent;
                    // Afficher le message avec le thème choisi
                    console.log(chosenTheme);
                    themeProposalContainer.classList.add("hide");
                    setTimeout(function () {
                        welcomeMessageContainer.classList.add("hide");
                    }, 1); // Délai d'affichage des propositions de thème (1000ms)
                    setTimeout(function () {
                        showWelcomeThemeMessage(chosenTheme);
                    }, 1500); // Délai d'affichage des propositions de thème (1000ms)

                });
            });

        });

        function insertJoueur(pseudo, themeChoisi) {
            fetch('insertJoueur.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                // Les données sont envoyées au serveur sous forme de chaîne de requête
                body: 'nomJoueur=' + encodeURIComponent(pseudo) + '&themeChoisi=' + encodeURIComponent(themeChoisi)
            })
                .then(response => response.text())
                .then(result => console.log(result))
                .catch(error => console.error('Erreur:', error));
        }
    </script>
</head>

<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="logobanniere.png" alt="Logo du jeu de rôle">
            </div>
            <h1 class="header-title">Destins Croisés</h1>

        </div>



    </header>



    <div class="background-container">


        <nav>
            <ul>
                <li><a href="#">Règle du jeu</a></li>
                <li><a href="#">Équipe</a></li>
                <li><a href="#">À propos</a></li>
            </ul>
        </nav>


        <div class="input-container">
            <input type="text" placeholder="Entrez votre pseudo">
            <button>Valider</button>
        </div>
        <div class="welcome-message-container">
            <div class="welcome-message">Bienvenue <span id="pseudo"></span> ! Veuillez choisir un thême parmi ceux
                proposés
                ci-dessous !</div>
        </div>
        <div class="theme-welcome-container">
            <div class="welcome-message">Vous avez choisi le thème <span id="theme"></span> ! Que la partie commence !
            </div>
        </div>
        <div class="theme-proposal-container">
            <button class="theme-button">Fantasy Médiévale</button>
            <button class="theme-button">Science-Fiction</button>
            <button class="theme-button">Post-Apocalyptique</button>
            <button class="theme-button">Horreur</button>
            <button class="theme-button">Survie</button>
        </div>
    </div>

</body>

</html>