<?php
// Shared helper functions for all API endpoints

function json_response(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

function require_method(string $method): void
{
    if ($_SERVER['REQUEST_METHOD'] !== $method) {
        json_response(['success' => false, 'message' => "Method not allowed. Use $method."], 405);
    }
}

// Reads JSON request body (falls back to form data)
function read_input(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $_POST;
}

// Validates and cleans appointment fields. Returns [cleanData, errors]
function validate_appointment(array $in): array
{
    $d = [
        'patient_name'     => trim($in['patient_name'] ?? ''),
        'email'            => trim($in['email'] ?? ''),
        'phone'            => trim($in['phone'] ?? ''),
        'appointment_date' => trim($in['appointment_date'] ?? ''),
        'appointment_time' => trim($in['appointment_time'] ?? ''),
        'doctor'           => trim($in['doctor'] ?? ''),
        'reason'           => trim($in['reason'] ?? ''),
    ];

    $errors = [];
    if ($d['patient_name'] === '') { $errors[] = 'Patient name is required.'; }
    if ($d['email'] === '' || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'A valid email address is required.'; }
    if ($d['phone'] === '') { $errors[] = 'Phone number is required.'; }
    if ($d['appointment_date'] === '') { $errors[] = 'Appointment date is required.'; }
    if ($d['appointment_time'] === '') { $errors[] = 'Appointment time is required.'; }
    if ($d['doctor'] === '') { $errors[] = 'Please select a doctor.'; }

    return [$d, $errors];
}
