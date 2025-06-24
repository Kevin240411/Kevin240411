const API_KEY = '7ef7409c2763b162ca0a39d9'; // ¡OBTEN TU PROPIA CLAVE API!
const API_URL = `https://v6.exchangerate-api.com/v6/${API_KEY}/latest/USD`; // URL correcta

async function obtenerTasasDeCambio() {
    try {
        const response = await fetch(API_URL);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const data = await response.json();

        // Verifica que existan las tasas
        const tasaEUR = data.conversion_rates.EUR;
        const tasaGBP = data.conversion_rates.GBP;
        const tasaJPY = data.conversion_rates.JPY;

        document.getElementById('tasaEUR').textContent = `1 USD = ${tasaEUR.toFixed(4)} EUR`;
        document.getElementById('tasaGBP').textContent = `1 USD = ${tasaGBP.toFixed(4)} GBP`;
        document.getElementById('tasaJPY').textContent = `1 USD = ${tasaJPY.toFixed(4)} JPY`;

    } catch (error) {
        console.error("Hubo un error al obtener las tasas de cambio:", error);
        document.getElementById('tasaEUR').textContent = "Error al cargar.";
        document.getElementById('tasaGBP').textContent = "Error al cargar.";
        document.getElementById('tasaJPY').textContent = "Error al cargar.";
    }
}

// Llama a la función cuando la página se cargue
document.addEventListener('DOMContentLoaded', () => {
    obtenerTasasDeCambio();
    setInterval(obtenerTasasDeCambio, 120000); // 120000 ms = 2 minutos
});
