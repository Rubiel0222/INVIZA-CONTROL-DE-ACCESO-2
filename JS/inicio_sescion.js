document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');

  loginForm.addEventListener('submit', async function(event) {
    event.preventDefault();

    const nombre_usuario = document.getElementById('nombre_usuario').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!nombre_usuario || !password) {
      alert('❌ Usuario y contraseña son obligatorios.');
      return;
    }

    try {
      const response = await fetch('/inviza/inicio_sesion.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre_usuario, password })
      });

      const data = await response.json();

      if (data.status === 'success') {
        window.location.replace("/inviza/pagina_inicial.php");
      } else {
        alert(`❌ ${data.message}`);
      }

    } catch (error) {
      console.error('🔴 Error de red:', error);
      alert('No se pudo establecer conexión con el servidor. Intenta nuevamente.');
    }
  });
});

