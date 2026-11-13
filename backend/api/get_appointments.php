<?php
// READ (all) - GET /backend/api/get_appointments.php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/helpers.php';

require_method('GET');

try {
    $sql = 'SELECT id, patient_name, email, phone, appointment_date, appointment_time, doctor, reason, created_at
            FROM appointments
            ORDER BY appointment_date ASC, appointment_time ASC';
    $appointments = $pdo->query($sql)->fetchAll();
    json_response(['success' => true, 'data' => $appointments]);
} catch (PDOException $e) {
    json_response(['success' => false, 'message' => 'Unable to fetch appointments.'], 500);
}
