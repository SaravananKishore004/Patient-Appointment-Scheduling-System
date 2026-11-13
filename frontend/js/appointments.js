// Dashboard: list appointments, delete appointments
const tableEl = document.getElementById('appointmentsTable');
const bodyEl = document.getElementById('appointmentsBody');

async function loadAppointments() {
    const result = await apiRequest('get_appointments.php');

    if (!result.success) {
        tableEl.hidden = true;
        showMessage(result.message || 'Unable to load appointments.', 'error');
        return;
    }

    if (result.data.length === 0) {
        tableEl.hidden = true;
        showMessage('No appointments have been scheduled yet.', 'info');
        return;
    }

    document.getElementById('message').hidden = true;
    bodyEl.innerHTML = result.data.map((a) => `
        <tr>
            <td>${escapeHtml(a.id)}</td>
            <td>${escapeHtml(a.patient_name)}</td>
            <td>${escapeHtml(a.email)}</td>
            <td>${escapeHtml(a.phone)}</td>
            <td>${escapeHtml(a.appointment_date)}</td>
            <td>${escapeHtml(a.appointment_time)}</td>
            <td>${escapeHtml(a.doctor)}</td>
            <td>${escapeHtml(a.reason)}</td>
            <td class="actions-cell">
                <a class="button-small button-link" href="edit.html?id=${encodeURIComponent(a.id)}">Edit</a>
                <button type="button" class="button-small button-delete" data-id="${escapeHtml(a.id)}">Delete</button>
            </td>
        </tr>`).join('');
    tableEl.hidden = false;
}

bodyEl.addEventListener('click', async (e) => {
    const btn = e.target.closest('.button-delete');
    if (!btn) return;
    if (!confirm('Delete this appointment?')) return;

    const result = await postJson('delete_appointment.php', { id: Number(btn.dataset.id) });
    if (result.success) {
        loadAppointments();
    } else {
        showMessage(result.message || 'Unable to delete appointment.', 'error');
    }
});

loadAppointments();
