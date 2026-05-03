<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Add Event</h1>

<form method="POST">

<input type="text" name="name" placeholder="Event Name" required>

<input type="date" name="date" required>

<input type="text" name="location" placeholder="Location">

<input type="text" name="venue" placeholder="Venue Type">

<select name="status">
    <option value="Planned">Planned</option>
    <option value="Ongoing">Ongoing</option>
    <option value="Completed">Completed</option>
</select>

<button type="submit" name="add">Add Event</button>

</form>

</div>

<?php
if (isset($_POST['add'])) {

    $stmt = $conn->prepare("
        INSERT INTO EVENTS (Event_name, Event_date, Location, Venue_type, Status)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssss",
        $_POST['name'],
        $_POST['date'],
        $_POST['location'],
        $_POST['venue'],
        $_POST['status']
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>