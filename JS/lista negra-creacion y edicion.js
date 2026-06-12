<script>
document.addEventListener('DOMContentLoaded', function() {
    // 🕒 Función para actualizar la hora actual
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById("currentTime");
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString();
        }
    }
    setInterval(updateTime, 1000);
    updateTime();

    // 🔍 Función de búsqueda en tabla
    const searchInput = document.querySelector('.search-container input[aria-label="Buscar"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).map(cell => cell.textContent.toLowerCase());
                const matches = rowData.some(data => data.includes(query));
                row.style.display = matches ? '' : 'none';
            });
        });
    }

    // ➕ Función para agregar un nuevo registro
    const addButton = document.querySelector('.add-button');
    if (addButton) {
        addButton.addEventListener('click', function() {
            const tableBody = document.querySelector('table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td contenteditable="true">Nuevo ID</td>
                <td contenteditable="true">Nuevo Documento</td>
                <td contenteditable="true">Nuevo Nombre</td>
                <td>
                    <button onclick="editRecord(this)">Editar</button>
                    <button onclick="deleteRecord(this)">Borrar</button>
                    <button onclick="saveToDatabase(this)">Guardar en BD</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            alert('Nuevo registro agregado');
        });
    }

    // ✏️ Función para editar un registro
    window.editRecord = function(button) {
        const row = button.closest('tr');
        const cells = row.querySelectorAll('td[contenteditable]');

        if (button.textContent === 'Editar') {
            cells.forEach(cell => {
                const originalText = cell.textContent;
                cell.innerHTML = `<input type="text" value="${originalText}">`;
            });
            button.textContent = 'Guardar';
        } else if (button.textContent === 'Guardar') {
            cells.forEach(cell => {
                const input = cell.querySelector('input');
                if (input) {
                    cell.textContent = input.value;
                }
            });
            button.textContent = 'Editar';
        }
    };

    // 🗑️ Función para eliminar un registro
    window.deleteRecord = function(button) {
        const row = button.closest('tr');
        row.remove();
        alert('Registro eliminado');
    };

    // 💾 Función para guardar en la BD (tabla horarios)
    window.saveToDatabase = function(button) {
        const row = button.closest('tr');
        const cells = row.querySelectorAll('td');
        const data = {
            id: cells[0].textContent.trim(),
            documento: cells[1].textContent.trim(),
            nombre: cells[2].textContent.trim()
        };

        fetch("guardar_lista_negra.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
        .then(res => res.text())
        .then(msg => alert(msg))
        .catch(err => alert("Error al guardar en horarios"));
    };

    // 🔙 Botón Regresar con redirección
    const regresarBtn = document.getElementById("btnRegresar");
    if (regresarBtn) {
        regresarBtn.addEventListener("click", function() {
            window.location.href = "lista negra-creacion y edición.php"; // Ajusta la ruta según tu sistema
        });
    }
});
</script>
