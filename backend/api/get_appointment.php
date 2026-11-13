<?php
// READ (one) - GET /backend/api/get_appointment.php?id=1
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/helpers.php';

require_method('GET');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    json_response(['success' => false, 'message' => 'Invalid appointment ID.'], 400);
}

try {
    $stmt = $pdo->prepare('SELECT id, patient_name, email, phone, appointment_date, appointment_time, doctor, reason
                           FROM appointments WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $appointment = $stmt->fetch();

    if (!$appointment) {
        json_response(['success' => false, 'message' => 'Appointment not found.'], 404);
    }
    json_response(['success' => true, 'data' => $appointment]);
} catch (PDOException $e) {
    json_response(['success' => false, 'message' => 'Unable to fetch appointment.'], 500);
}
