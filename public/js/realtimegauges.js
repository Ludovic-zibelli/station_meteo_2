function updateRealtimeGauges() {
    fetch('/api/update-realtime-gauges', {
        method: 'POST',
    })
    .then(response => response.json())
    .then(data => {
        console.log('Realtime gauges updated:', data);
    })
    .catch(error => {
        console.error('Error updating realtime gauges:', error);
    });
}

// Appeler la fonction toutes les 30 secondes
setInterval(updateRealtimeGauges, 30000);