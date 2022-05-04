<?php
// Require database helper
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dbConn.php';

/**
 * Get all messages from database
 *
 * @return array|false
 */
function getMessages()
{
    global $pdo;

    try {
        $sql = "SELECT * FROM message;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [$e->getCode() => $e->getMessage()];
    }
}

function getMessage(int $id)
{
    global $pdo;

    try {
        $sql = "SELECT * FROM message WHERE id = :id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [$e->getCode() => $e->getMessage()];
    }
}

/**
 * Insert a message in database
 *
 * @param array $message
 *
 * @return array|false|string
 */
function insertMessage(array $message)
{
    global $pdo;
    $message['sent_at'] = date('Y-m-d H:i:s');

    try {
        $sql = "INSERT INTO message (name, email, message, sent_at) VALUES (:name, :email, :message, :sentAt);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('name', $message['name']);
        $stmt->bindParam('email', $message['email']);
        $stmt->bindParam('message', $message['message']);
        $stmt->bindParam('sentAt', $message['sent_at']);
        $stmt->execute();

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return [$e->getCode() => $e->getMessage()];
    }
}

function updateMessage(array $message)
{
    global $pdo;

    try {
        $sql = "UPDATE message SET name = :name, email = :email, message = :message WHERE id = :id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('name', $message['name']);
        $stmt->bindParam('email', $message['email']);
        $stmt->bindParam('message', $message['message']);
        $stmt->bindParam('id', $message['id']);
        $stmt->execute();

        return $message['id'];
    } catch (PDOException $e) {
        return [$e->getCode() => $e->getMessage()];
    }
}

/**
 * Delete a message from database
 *
 * @param int $id
 *
 * @return void
 */
function deleteMessage(int $id)
{
    global $pdo;

    try {
        $sql = "DELETE FROM message WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('id', $id);
        $stmt->execute();

        Header('Location: ../index.php');
    } catch (PDOException $e) {
        var_dump($e->getCode(), $e->getMessage());
        exit;
    }
}

// Get desired mode (if this file is called from an url)
$mode = $_GET['mode'] ?? null;

switch ($mode) {
    // Delete a message
    case 'delete':
        $id = $_GET['id'] ?? null;
        deleteMessage($id);
        break;
    default:
        break;
}
