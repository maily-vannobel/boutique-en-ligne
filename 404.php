<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page non trouvée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 50px;
        }
        p {
            font-size: 20px;
        }
        a {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>La page que vous cherchez n'existe pas.</p>
    <p><a href="/index.php">Retour à l'accueil</a></p>
</body>
</html>


<!--
Instructions pour configurer la page d'erreur 404 personnalisée :

1. Ouvrez le fichier de configuration principal d'Apache (`httpd.conf`) logo wamp>apache>httpconf

2. Recherchez le bloc `<Directory>` pour votre répertoire racine et assurez-vous qu'il contient `AllowOverride All`  et granted :
