<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch event
$stmt = $conn->prepare("SELECT * FROM EVENTS WHERE Event_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    header("Location: index.php");
    exit();
}
?>

<div class="main">

<h1>Edit Event</h1>

<form method="POST">

<input type="text" name="name" value="<?= htmlspecialchars($event['Event_name']) ?>" required>

<input type="date" name="date" value="<?= $event['Event_date'] ?>" required>

<input type="text" name="location" value="<?= htmlspecialchars($event['Location']) ?>">

<input type="text" name="venue" value="<?= htmlspecialchars($event['Venue_type']) ?>">

<select name="status">
    <option value="Planned" <?= $event['Status']=='Planned'?'selected':'' ?>>Planned</option>
    <option value="Ongoing" <?= $event['Status']=='Ongoing'?'selected':'' ?>>Ongoing</option>
    <option value="Completed" <?= $event['Status']=='Completed'?'selected':'' ?>>Completed</option>
</select>

<button type="submit" name="update">Update Event</button>

</form>

</div>

<?php
if (isset($_POST['update'])) {

    $stmt = $conn->prepare("
        UPDATE EVENTS
        SET Event_name=?, Event_date=?, Location=?, Venue_type=?, Status=?
        WHERE Event_ID=?
    ");

    $stmt->bind_param(
        "sssssi",
        $_POST['name'],
        $_POST['date'],
        $_POST['location'],
        $_POST['venue'],
        $_POST['status'],
        $id
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>