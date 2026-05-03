<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Dashboard</h1>
<h2>Welcome, <?= $_SESSION['name'] ?? 'User' ?></h2>

<!-- ===== STATS ROW ===== -->
<div class="stats-row">

    <div class="card stat">
        <h3>Total Orders</h3>
        <?php
        $r = $conn->query("SELECT COUNT(*) AS total FROM ORDERS");
        echo "<p>" . $r->fetch_assoc()['total'] . "</p>";
        ?>
    </div>

    <div class="card stat">
        <h3>Total Customers</h3>
        <?php
        $r = $conn->query("SELECT COUNT(*) AS total FROM CUSTOMER");
        echo "<p>" . $r->fetch_assoc()['total'] . "</p>";
        ?>
    </div>

    <div class="card stat">
        <h3>Low Stock</h3>
        <?php
        $r = $conn->query("
            SELECT COUNT(*) AS total 
            FROM INVENTORY 
            WHERE Quantity_available <= Reorder_level
        ");
        echo "<p>" . $r->fetch_assoc()['total'] . "</p>";
        ?>
    </div>

</div>

<!-- ===== GRID SECTION ===== -->
<div class="dashboard-grid">

    <!-- Recent Orders -->
    <div class="card">
        <h3>Recent Orders</h3>

        <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>

        <?php
        $result = $conn->query("
            SELECT * FROM Order_Details_View
            ORDER BY Order_time DESC
            LIMIT 5
        ");

        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row['Order_ID'] ?></td>
            <td><?= $row['First_name'] . " " . $row['Last_name'] ?></td>
            <td><?= $row['Order_Status'] ?></td>
            <td><?= $row['Amount_paid'] ?? 'N/A' ?></td>
        </tr>
        <?php } ?>
        </table>

        <a href="/mawzoon_frontend/pages/views/orders.php" class="btn primary">
            View All
        </a>
    </div>

    <!-- Low Stock -->
    <div class="card">
        <h3>Low Stock Items</h3>

        <table>
        <tr>
            <th>Ingredient</th>
            <th>Qty</th>
        </tr>

        <?php
        $result = $conn->query("
            SELECT * FROM Inventory_Status_View
            WHERE Quantity_available <= Reorder_level
            LIMIT 5
        ");

        while ($row = $result->fetch_assoc()) {
        ?>
        <tr style="background:#ffcccc;">
            <td><?= $row['Ingredient_name'] ?></td>
            <td><?= $row['Quantity_available'] ?></td>
        </tr>
        <?php } ?>
        </table>

        <a href="/mawzoon_frontend/pages/views/inventory.php" class="btn primary">
            View
        </a>
    </div>

    <!-- Event Menu -->
    <div class="card">
        <h3>Event Menu</h3>

        <table>
        <tr>
            <th>Event</th>
            <th>Item</th>
        </tr>

        <?php
        $result = $conn->query("
            SELECT * FROM Event_Menu_View
            LIMIT 5
        ");

        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row['Event_name'] ?></td>
            <td><?= $row['Item_name'] ?></td>
        </tr>
        <?php } ?>
        </table>

        <a href="/mawzoon_frontend/pages/views/event_menu.php" class="btn primary">
            View
        </a>
    </div>

</div>

</div>