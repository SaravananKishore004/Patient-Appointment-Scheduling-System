// Shared helpers: backend API base URL, request wrapper, message box, HTML escaping
const API_BASE = '../backend/api';

async function apiRequest(endpoint, options = {}) {
    try {
        const response = await fetch(`${API_BASE}/${endpoint}`, options);
        return await response.json();
    } catch (err) {
        return { success: false, message: 'Cannot reach the server. Make sure Apache and MySQL are running.' };
    }
}

function postJson(endpoint, payload) {
    return apiRequest(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
    });
}

function showMessage(text, type) {
    const box = document.getElementById('message');
    if (!box) return;
    box.textContent = text;
    box.className = `message-card ${type}`;
    box.hidden = false;
}

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
