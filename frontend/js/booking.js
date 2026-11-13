// Booking page: create a new appointment
document.getElementById('appointmentForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const payload = Object.fromEntries(new FormData(form).entries());

    const result = await postJson('create_appointment.php', payload);

    if (result.success) {
        showMessage(result.message, 'success');
        form.reset();
    } else {
        showMessage(result.message || 'Something went wrong.', 'error');
    }
});
