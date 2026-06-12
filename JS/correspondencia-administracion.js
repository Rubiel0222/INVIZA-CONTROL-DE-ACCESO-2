document.addEventListener("DOMContentLoaded", function () {
    cargarCorrespondencia();

    document.getElementById("searchButton").addEventListener("click", function () {
        const query = document.getElementById("searchInput").value.toLowerCase();
        document.querySelectorAll("#correspondencia-table tr").forEach(row => {
            row.style.display = !query || row.innerText.toLowerCase().includes(query) ? "" : "none";
        });
    });

    document.getElementById("addButton").addEventListener("click", function () {
        window.location.href = "correspondencia-administración.php"; // redirige en la misma ventana
    });
});

function cargarCorrespondencia() {
    fetch("cargar_correspondencia.php")
        .then(response => response.json())
        .then(data => renderizarTabla(data))
        .catch(error => console.error("❌ Error al cargar datos:", error));
}

function renderizarTabla(data) {
    const tableBody = document.getElementById("correspondencia-table");
    if (!tableBody) return;

    tableBody.innerHTML = "";
    data.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.descripcion}</td>
            <td>${item.destinatario}</td>
            <td>${item.propietario}</td>
            <td>${item.ubicacion}</td>
            <td>${item.telefono}</td>
            <td>${item.codigo_envio}</td>
            <td>${item.entregado_por}</td>
            <td>${item.enviar_correo ? "✅" : "❌"}</td>
            <td><button class="delete-button">🗑 Borrar</button></td>
        `;
        tableBody.appendChild(row);

        // Acción borrar
        row.querySelector(".delete-button").addEventListener("click", () => {
            eliminarCorrespondencia(item.codigo_envio);
        });
    });
}

function eliminarCorrespondencia(codigo) {
    fetch("eliminar_correspondencia.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "codigo_envio=" + encodeURIComponent(codigo)
    })
    .then(res => res.text())
    .then(msg => {
        alert(msg);
        cargarCorrespondencia();
    })
    .catch(err => console.error("❌ Error al eliminar:", err));
}
