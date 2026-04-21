<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Database connection
|--------------------------------------------------------------------------
*/
$host = 'localhost';
$dbname = 'rep_cafe';
$username = 'root';
$password = 'root';
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
| Volunteer CRUD
|--------------------------------------------------------------------------
*/
function createVolunteer(PDO $pdo, string $name, string $email): bool
{
    $sql = "INSERT INTO volunteers (name, email)
            VALUES (:name, :email)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
        ':email' => $email
    ]);
}

function getAllVolunteers(PDO $pdo): array
{
    $sql = "SELECT * FROM volunteers ORDER BY name ASC";
    return $pdo->query($sql)->fetchAll();
}

function getVolunteerById(PDO $pdo, int $id): array|false
{
    $sql = "SELECT * FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

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

function deleteVolunteer(PDO $pdo, int $id): bool
{
    $sql = "DELETE FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id
    ]);
}

/*
|--------------------------------------------------------------------------
| Event CRUD
|--------------------------------------------------------------------------
*/
function createEvent(PDO $pdo, string $title, DateTime $date, string $location): bool
{
    $sql = "INSERT INTO events (title, date, location)
            VALUES (:title, :date, :location)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':title' => $title,
        ':date' => $date->format('Y-m-d H:i'),
        ':location' => $location
    ]);
}

function getAllEvents(PDO $pdo): array
{
    $sql = "SELECT * FROM events ORDER BY date ASC";
    return $pdo->query($sql)->fetchAll();
}

function getEventById(PDO $pdo, int $id): array|false
{
    $sql = "SELECT * FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

function updateEvent(PDO $pdo, int $id, string $title, DateTime $date, string $location): bool
{
    $sql = "UPDATE events
            SET title = :title,
                date = :date,
                location = :location
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':date' => $date->format('Y-m-d H:i:s'),
        ':location' => $location
    ]);
}

function deleteEvent(PDO $pdo, int $id): bool
{
    $sql = "DELETE FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id
    ]);
}

/*
|--------------------------------------------------------------------------
| Event <-> Volunteer relation
|--------------------------------------------------------------------------
*/
function addVolunteerToEvent(PDO $pdo, int $volunteerId, int $eventId): bool
{
    $sql = "INSERT INTO event_volunteers (volunteer_id, event_id)
            VALUES (:volunteer_id, :event_id)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':volunteer_id' => $volunteerId,
        ':event_id' => $eventId
    ]);
}

function removeVolunteerFromEvent(PDO $pdo, int $volunteerId, int $eventId): bool
{
    $sql = "DELETE FROM event_volunteers
            WHERE volunteer_id = :volunteer_id
              AND event_id = :event_id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':volunteer_id' => $volunteerId,
        ':event_id' => $eventId
    ]);
}

/*
|--------------------------------------------------------------------------
| Read events with volunteer names
|--------------------------------------------------------------------------
*/
function getAllEventsWithVolunteers(PDO $pdo): array
{
    $sql = "
        SELECT
            events.id,
            events.title,
            events.date,
            events.location,
            volunteers.name AS volunteer_name
        FROM events
        LEFT JOIN event_volunteers
            ON events.id = event_volunteers.event_id
        LEFT JOIN volunteers
            ON event_volunteers.volunteer_id = volunteers.id
        ORDER BY events.date ASC, volunteers.name ASC
    ";

    $rows = $pdo->query($sql)->fetchAll();

    $events = [];

    foreach ($rows as $row) {
        $eventId = (int)$row['id'];

        if (!isset($events[$eventId])) {
            $events[$eventId] = [
                'id' => $eventId,
                'title' => $row['title'],
                'date' => $row['date'],
                'location' => $row['location'],
                'volunteers' => []
            ];
        }

        if (!empty($row['volunteer_name'])) {
            $events[$eventId]['volunteers'][] = $row['volunteer_name'];
        }
    }

    return array_values($events);
}