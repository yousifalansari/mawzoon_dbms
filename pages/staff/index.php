<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Staff</h1>
<p style="color:gray;">
Staff data is restricted and managed by administrators only.
</p>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM STAFF");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Staff_ID'] ?></td>
    <td><?= htmlspecialchars($row['First_name'] . " " . $row['Last_name']) ?></td>
    <td><?= htmlspecialchars($row['Email']) ?></td>
    <td><?= htmlspecialchars($row['Role'] ?? 'Staff') ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>