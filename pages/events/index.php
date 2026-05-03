<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Events</h1>

<a href="add.php">
    <button>Add Event</button>
</a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Date</th>
    <th>Location</th>
    <th>Venue</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM EVENTS");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Event_ID'] ?></td>
    <td><?= htmlspecialchars($row['Event_name']) ?></td>
    <td><?= $row['Event_date'] ?></td>
    <td><?= htmlspecialchars($row['Location']) ?></td>
    <td><?= htmlspecialchars($row['Venue_type']) ?></td>
    <td><?= htmlspecialchars($row['Status']) ?></td>
    <td>
        <a href="edit.php?id=<?= $row['Event_ID'] ?>">
            <button>Edit</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>