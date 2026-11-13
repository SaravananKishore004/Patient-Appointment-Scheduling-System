<?php
// UPDATE - POST /backend/api/update_appointment.php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/helpers.php';

require_method('POST');
$input = read_input();

$id = isset($input['id']) ? (int) $input['id'] : 0;
if ($id <= 0) {
    json_response(['success' => false, 'message' => 'Invalid appointment ID.'], 400);
}

[$data, $errors] = validate_appointment($input);
if (!empty($errors)) {
    json_response(['success' => false, 'message' => implode(' ', $errors), 'errors' => $errors], 422);
}

try {
    $sql = 'UPDATE appointments
            SET patient_name = :patient_name, email = :email, phone = :phone,
                appointment_date = :appointment_date, appointment_time = :appointment_time,
                doctor = :doctor, reason = :reason
            WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':patient_name'     => $data['patient_name'],
        ':email'            => $data['email'],
        ':phone'            => $data['phone'],
        ':appointment_date' => $data['appointment_date'],
        ':appointment_time' => $data['appointment_time'],
        ':doctor'           => $data['doctor'],
        ':reason'           => $data['reason'],
        ':id'               => $id,
    ]);
    json_response(['success' => true, 'message' => 'Appointment successfully updated.']);
} catch (PDOException $e) {
    json_response(['success' => false, 'message' => 'Unable to update appointment.'], 500);
}
