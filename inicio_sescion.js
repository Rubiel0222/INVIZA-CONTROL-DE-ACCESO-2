document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("ingresarbtn");

    if (!loginBtn) {
        console.error("Botón 'ingresarbtn' no encontrado.");
        return;
    }

    loginBtn.addEventListener("click", async function () {
        const usuario = document.getElementById("usuarioinput").value.trim();
        const clave = document.getElementById("claveinput").value.trim();

        if (!usuario || !clave) {
            alert("Por favor, completa todos los campos.");
            return;
        }

        try {
            const response = await fetch("inicio_sesion.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    nombre_usuario: usuario,
                    password: clave
                })
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();
            console.log("Respuesta del servidor:", data);

            if (data.status === "success") {
                alert("✅ Inicio de sesión exitoso");
               window.location.href = "/inviza/pagina_inicial.html";




            } else {
                alert("❌ " + data.message);
            }
        } catch (error) {
            console.error("Error al conectar con el servidor:", error);
            alert("⚠️ No se pudo establecer conexión con el servidor. Verifica que el archivo PHP esté disponible.");
        }
    });
});

