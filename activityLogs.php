<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$logs = getActivityLogs($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Activity Logs</title>
</head>
<body>
    <a href="index.php"><h2>Activity Logs</h2></a>
    <table border="1">
        <thead>
            <tr>
                <th>User</th>
                <th>Action Type</th>
                <th>Action Details</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
    <?php if (empty($logs)): ?>
        <tr>
            <td colspan="4">No logs found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['user']) ?></td>
                <td><?= htmlspecialchars($log['action_type']) ?></td>
                <td><?= htmlspecialchars($log['action_details']) ?></td>
                <td><?= htmlspecialchars($log['date_added']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
    </table>
</body>
</html>