<video id="video" width="320" height="240" autoplay></video>
<img id="photoPreview" style="display:none;" alt="Foto Capturada">
<button type="button" id="captureButton">Tomar Foto</button>
<input type="hidden" id="photoData" name="foto">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 🕒 Actualizar hora
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const currentTimeElement = document.getElementById('currentTime');
        if (currentTimeElement) {
            currentTimeElement.textContent = `${hours}:${minutes}`;
        }
    }
    setInterval(updateTime, 1000);
    updateTime();

    // 📷 Cámara
    const video = document.getElementById('video');
    const photoPreview = document.getElementById('photoPreview');
    const captureButton = document.getElementById('captureButton');
    const photoData = document.getElementById('photoData');

    if (video && captureButton && photoPreview && photoData) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.play();
            })
            .catch(error => {
                console.error("Error al acceder a la cámara:", error);
                alert("No se puede acceder a la cámara. Usa HTTPS o habilita permisos.");
            });

        captureButton.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/jpeg');
            photoPreview.src = imageData;
            photoPreview.style.display = 'block';
            video.style.display = 'none';
            photoData.value = imageData;

            alert("Foto capturada con éxito.");
        });
    }
});
</script>

