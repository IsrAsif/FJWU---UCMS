<?php
session_start();
require_once '../../includes/db.php';

// Check if user is logged in and is a faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'faculty') {
    header("Location: /ucms/auth/login.php");
    exit();
}

$faculty_id = $_SESSION['user_id'];
$base_path = '/ucms';

// Get complaint history
$history_sql = "SELECT ch.*, c.subject, c.id as complaint_id, u.name as student_name,
                d.name as department_name
                FROM complaint_history ch
                JOIN complaints c ON ch.complaint_id = c.id
                JOIN users u ON c.user_id = u.id
                JOIN departments d ON c.department_id = d.id
                WHERE ch.faculty_id = ?
                ORDER BY ch.created_at DESC";

$stmt = $conn->prepare($history_sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$history_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint History - UCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>/assets/css/style.css">
</head>
<body>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">
    <div class="container mt-4">
        <h3>Complaint History</h3>
        
        <?php if ($history_result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Complaint ID</th>
                            <th>Subject</th>
                            <th>Student</th>
                            <th>Department</th>
                            <th>Action</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($history = $history_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $history['complaint_id']; ?></td>
                                <td><?php echo htmlspecialchars($history['subject']); ?></td>
                                <td><?php echo htmlspecialchars($history['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($history['department_name']); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $history['action'] === 'assigned' ? 'primary' : 
                                            ($history['action'] === 'in_progress' ? 'info' : 
                                            ($history['action'] === 'resolved' ? 'success' : 'secondary')); 
                                    ?>">
                                        <?php echo ucfirst($history['action']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($history['comment']); ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($history['created_at'])); ?></td>
                                <td>
                                    <a href="view_complaint.php?id=<?php echo $history['complaint_id']; ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No complaint history found.
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base_path; ?>/assets/js/main.js"></script>
</body>
</html> 