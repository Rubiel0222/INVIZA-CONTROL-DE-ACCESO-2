document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("generar").addEventListener("click", async () => {
        const tabla = document.getElementById("tabla").value;
        const fecha_ingreso = document.getElementById("fecha_ingreso").value;
        const fecha_final = document.getElementById("fecha_final").value;
        const cedula = document.getElementById("cedula").value.trim();
        const formato = document.getElementById("formato").value;

        if (!tabla || !fecha_ingreso || !fecha_final || !cedula || !formato) {
            alert("Por favor completa todos los campos.");
            return;
        }

        const payload = { tabla, fecha_ingreso, fecha_final, cedula, formato };

        try {
            const response = await fetch("/inviza/backend/procesar-informes.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            if (!response.ok) throw new Error("Error al generar el informe");

            const blob = await response.blob();

            if (blob.size < 100) {
                alert("El informe generado está vacío o no contiene registros.");
                return;
            }

            const url = window.URL.createObjectURL(blob);
            const nombreArchivo = `informe_${tabla}_${cedula}.${formato === "pdf" ? "pdf" : "xlsx"}`;

            const a = document.createElement("a");
            a.href = url;
            a.download = nombreArchivo;
            document.body.appendChild(a);
            a.click();
            a.remove();

            window.URL.revokeObjectURL(url);

            if (formato === "pdf") {
                window.open(url, "_blank");
            }

            alert(`Informe generado correctamente como ${nombreArchivo}`);
        } catch (error) {
            alert("No se pudo generar el informe. Verifica los datos o contacta soporte.");
            console.error(error);
        }
    });
});

