<?php
// Show errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require messages helper
require_once('inc/messages.php');

// Get id from url params
$id = $_GET['id'] ?? null;

// Get message from database
$message = getMessage($id);

if (!$message) {
    //Header('Location: index.php');
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />

        <title>Modifier un message - PHP Starter</title>

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
            <h1>Modifier un message</h1>
            <h2>PHP Starter</h2>
        </header>

        <main class="app-main">
            <form action="inc/form.php?mode=update&id=<?php echo $message['id']; ?>" method="post" class="app-form" novalidate>
                <div class="form-group">
                    <label for="name">Nom*</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $message['name'] ?? ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $message['email'] ?? ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="message">Message*</label>
                    <textarea name="message" id="message" rows="5" class="form-control"><?php echo stripslashes($message['message']) ?? ''; ?></textarea>
                </div>
                <button type="submit" class="app-button">Soumettre</button>
            </form>
        </main>

        <footer class="app-footer">
            <p>
                <a href="index.php" class="app-button">Liste des messages</a>
            </p>
            <p>
                <a href="nouveau.php" class="app-button">Nouveau message</a>
            </p>
        </footer>
    </body>
</html>
