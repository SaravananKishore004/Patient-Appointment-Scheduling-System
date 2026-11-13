<?php
// DELETE - POST /backend/api/delete_appointment.php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/helpers.php';

require_method('POST');
$input = read_input();

$id = isset($input['id']) ? (int) $input['id'] : 0;
if ($id <= 0) {
    json_response(['success' => false, 'message' => 'Invalid appointment ID.'], 400);
}

try {
    $stmt = $pdo->prepare('DELETE FROM appointments WHERE id = :id');
    $stmt->execute([':id' => $id]);
    json_response(['success' => true, 'message' => 'Appointment deleted.']);
} catch (PDOException $e) {
    json_response(['success' => false, 'message' => 'Unable to delete appointment.'], 500);
}
