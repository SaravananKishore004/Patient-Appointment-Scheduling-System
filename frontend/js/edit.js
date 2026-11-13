// Edit page: load an appointment, then save changes
const params = new URLSearchParams(window.location.search);
const appointmentId = Number(params.get('id'));
const form = document.getElementById('editForm');

async function loadAppointment() {
    if (!appointmentId) {
        window.location.href = 'appointments.html';
        return;
    }

    const result = await apiRequest(`get_appointment.php?id=${appointmentId}`);
    if (!result.success) {
        showMessage(result.message || 'Appointment not found.', 'error');
        form.hidden = true;
        return;
    }

    const a = result.data;
    document.getElementById('id').value = a.id;
    ['patient_name', 'email', 'phone', 'appointment_date', 'appointment_time', 'doctor', 'reason']
        .forEach((field) => { document.getElementById(field).value = a[field] ?? ''; });
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = Object.fromEntries(new FormData(form).entries());
    payload.id = appointmentId;

    const result = await postJson('update_appointment.php', payload);
    showMessage(result.message || 'Something went wrong.', result.success ? 'success' : 'error');
});

loadAppointment();
