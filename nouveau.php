<?php
// Show errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />

        <title>Nouveau message - PHP Starter</title>

        <link rel="stylesheet" href="css/styles.css" />

        <script defer>
            window.addEventListener('DOMContentLoaded', e => {
                const searchParams = new URLSearchParams(window.location.search)

                if (searchParams.has('erreurs')) {
                    const errors = JSON.parse(searchParams.get('erreurs'))

                    for (const field in errors) {
                        const inputField = document.getElementById(field)
                        const errorMessage = document.createElement('p')
                        errorMessage.classList.add('error')
                        errorMessage.innerHTML = errors[field]
                        inputField.parentNode.appendChild(errorMessage)
                    }
                }
            })
        </script>
    </head>
    <body>
        <header class="app-header">
            <h1>Ajouter un message</h1>
            <h2>PHP Starter</h2>
        </header>

        <main class="app-main">

            <form action="inc/form.php" method="post" class="app-form" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label for="name">Nom*</label>
                    <input type="text" name="name" id="name" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="message">Message*</label>
                    <textarea name="message" id="message" rows="5" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image du message</label>
                    <input type="file" id="image" name="image" class="form-control" />
                </div>

                <button type="submit" class="app-button">Soumettre</button>
            </form>

        </main>

        <footer class="app-footer">
            <p>
                <a href="index.php" class="app-button">Liste des messages</a>
            </p>
        </footer>
    </body>
</html>
