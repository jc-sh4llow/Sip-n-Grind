document.addEventListener('DOMContentLoaded', () => {
    // Function to request geolocation
    function requestGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const { latitude, longitude } = position.coords;

                    // Send to the server via API
                    fetch('api/temporary_location.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ latitude, longitude }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => console.error('Error:', error));
                },
                error => {
                    alert('Geolocation access denied.');
                    console.error(error);
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    }

    // Automatically trigger the geolocation request when the page loads
    requestGeolocation();
});
