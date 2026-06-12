document.addEventListener('DOMContentLoaded', () => {
    updateTime();
    setInterval(updateTime, 1000); // Actualiza la hora cada segundo
});

function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
}

function agregarDato() {
    const tbody = document.querySelector('table tbody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td contenteditable="true"></td>
        <td>
            <button onclick="editarFila(this)">Editar</button>
            <button onclick="borrarFila(this)">Borrar</button>
        </td>
    `;

    tbody.appendChild(newRow);
}

function editarFila(button) {
    const row = button.parentElement.parentElement;
    alert('Editar fila ' + row.rowIndex);
    sincronizarConBaseDeDatos('editar', {/* Datos a editar */});
}

function borrarFila(button) {
    const row = button.parentElement.parentElement;
    row.remove();
    alert('Fila borrada');
    sincronizarConBaseDeDatos('borrar', {/* ID de la fila a borrar */});
}

function sincronizarConBaseDeDatos(action, data) {
    fetch('tu_api.php', { // aquí debe ir tu PHP real
        method: action === 'borrar' ? 'DELETE' : 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Éxito:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

