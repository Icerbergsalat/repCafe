<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Database connection
|--------------------------------------------------------------------------
*/
$host = 'localhost';
$dbname = 'repair_cafe';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

/*
|--------------------------------------------------------------------------
| CRUD functions for volunteers
|--------------------------------------------------------------------------
*/

/**
 * CREATE
 */
function createVolunteer(PDO $pdo, int $id, string $name, string $email): bool
{
    $sql = "INSERT INTO volunteers (id, name, email)
            VALUES (:id, :name, :email)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':email' => $email,

    ]);
}

/**
 * READ ALL
 */
function getAllVolunteers(PDO $pdo): array
{
    $sql = "SELECT * FROM volunteers ORDER BY created_at DESC";
    return $pdo->query($sql)->fetchAll();
}

/**
 * READ ONE
 */
function getVolunteerById(PDO $pdo, int $id): array|false
{
    $sql = "SELECT * FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

/**
 * UPDATE
 */
function updateVolunteer(PDO $pdo, int $id, string $name, string $email): bool
{
    $sql = "UPDATE volunteers 
            SET name = :name,
                email = :email
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':email' => $email
    ]);
}

/**
 * DELETE
 */
function deleteVolunteer(PDO $pdo, int $id): bool
{
    $sql = "DELETE FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([':id' => $id]);
}
function createEvent(PDO $pdo, int $id, DateTime $date, string $title, string $location): bool
{
    $sql = "INSERT INTO events (id, date, title, location)
            VALUES (:id, :date, :title, :location)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':date' => $date->format('Y-m-d H:i:s'),
        ':title' => $title,
        ':location' => $location
    ]);
}

/**
 * READ ALL
 */
function getAllEvents(PDO $pdo): array
{
    $sql = "SELECT * FROM events ORDER BY date DESC";
    return $pdo->query($sql)->fetchAll();
}

/**
 * READ ONE
 */
function getEventById(PDO $pdo, int $id): array|false
{
    $sql = "SELECT * FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

/**
 * UPDATE
 */
function updateEvent(PDO $pdo, int $id, DateTime $date, string $title, string $location): bool
{
    $sql = "UPDATE events 
            SET date = :date,
                title = :title,
                location = :location
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':date' => $date->format('Y-m-d H:i:s'),
        ':title' => $title,
        ':location' => $location
    ]);
}

/**
 * DELETE
 */
function deleteEvent(PDO $pdo, int $id): bool
{
    $sql = "DELETE FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([':id' => $id]);
}