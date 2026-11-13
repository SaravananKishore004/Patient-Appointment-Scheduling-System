<?php
// CREATE - POST /backend/api/create_appointment.php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/helpers.php';

require_method('POST');
[$data, $errors] = validate_appointment(read_input());

if (!empty($errors)) {
    json_response(['success' => false, 'message' => implode(' ', $errors), 'errors' => $errors], 422);
}

try {
    $sql = 'INSERT INTO appointments (patient_name, email, phone, appointment_date, appointment_time, doctor, reason)
            VALUES (:patient_name, :email, :phone, :appointment_date, :appointment_time, :doctor, :reason)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':patient_name'     => $data['patient_name'],
        ':email'            => $data['email'],
        ':phone'            => $data['phone'],
        ':appointment_date' => $data['appointment_date'],
        ':appointment_time' => $data['appointment_time'],
        ':doctor'           => $data['doctor'],
        ':reason'           => $data['reason'],
    ]);
    json_response(['success' => true, 'message' => 'Appointment successfully booked.', 'id' => (int) $pdo->lastInsertId()], 201);
} catch (PDOException $e) {
    json_response(['success' => false, 'message' => 'Unable to save appointment.'], 500);
}
