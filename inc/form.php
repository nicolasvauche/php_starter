<?php
// Show errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require messages helper
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'messages.php';

// Define constants for error messages
const ERROR_EMPTY = 'Ce champ est obligatoire';
const ERROR_TOOSHORT = 'Veuillez saisir au moins 3 caractères dans ce champ';
const ERROR_INVALID = 'Veuillez saisir une donnée valide svp';
const ERROR_EMAIL = 'Veuillez saisir une adresse email valide svp';


/**
 * Validate each input of a given posted form
 *
 * @param array $formData
 *
 * @return array
 */
function validateForm(array $formData): array
{
    $errors = [];

    foreach ($formData as $key => $value) {
        switch ($key) {
            case 'name':
                if (empty($value)) {
                    $errors[$key] = ERROR_EMPTY;
                } elseif (strlen($value) < 3) {
                    $errors[$key] = ERROR_TOOSHORT;
                } elseif (!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u", $value)) {
                    $errors[$key] = ERROR_INVALID;
                }
                break;
            case 'email':
                if (empty($value)) {
                    $errors[$key] = ERROR_EMPTY;
                } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = ERROR_EMAIL;
                }
                break;
            case 'message':
                if (empty($value)) {
                    $errors[$key] = ERROR_EMPTY;
                } elseif (strlen($value) < 3) {
                    $errors[$key] = ERROR_TOOSHORT;
                }
                break;
            default:
                break;
        }
    }

    return $errors;
}

/**
 * Sanitize each input of a given posted form
 *
 * @param array $formData
 *
 * @return array
 */
function sanitizeForm(array $formData): array
{
    foreach ($formData as $key => $value) {
        switch ($key) {
            case 'name':
            case 'message':
                $formData[$key] = filter_var($value, FILTER_SANITIZE_ADD_SLASHES);
                $formData[$key] = trim($formData[$key]);
                break;
            case 'email':
                $formData[$key] = filter_var($value, FILTER_SANITIZE_EMAIL);
                $formData[$key] = trim($formData[$key]);
                break;
            default:
                break;
        }
    }

    return $formData;
}

// If we have posted data
if (count($_POST) > 0) {
    // Get desired mode (if this file is called from an url, else set it by default to 'add')
    $mode = $_GET['mode'] ?? 'add';

    // Validate form data
    $errors = validateForm($_POST);

    // Sanitize form data
    $message = sanitizeForm($_POST);

    switch ($mode) {
        // Update a message
        case 'update':
            $message = $_POST;
            $message['id'] = $_GET['id'] ?? null;

            if (count($errors) > 0) {
                // Redirect to form with errors
                Header('Location: ../modifier.php?id=' . $message['id'] . '&erreurs=' . json_encode($errors));
            } else {
                // Update message into database
                $result = updateMessage($message);

                if (is_array($result)) {
                    // Error has been returned
                    echo '<p>Une erreur est survenue :(</p>';
                    var_dump($result);
                } else {
                    // Redirect to list
                    Header('Location: ../index.php');
                }
            }
            break;
        case 'add':
            if (count($errors) > 0) {
                // Redirect to form with errors
                Header('Location: ../nouveau.php?erreurs=' . json_encode($errors));
            } else {
                // Insert message into database
                $result = insertMessage($message);

                if (is_array($result)) {
                    // Error has been returned
                    echo '<p>Une erreur est survenue :(</p>';
                    var_dump($result);
                } else {
                    // Redirect to list
                    Header('Location: ../index.php');
                }
            }
            break;
        default:
            break;
    }
}
