// Función asíncrona para obtener los precios de las criptomonedas
async function obtenerPreciosCripto() {
    // URL de la CoinGecko API para obtener precios de múltiples monedas
    // ids: bitcoin, ethereum, tether (los IDs de las monedas en CoinGecko)
    // vs_currencies: usd (la moneda en la que queremos ver el precio)
    const API_URL = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,tether&vs_currencies=usd';

    try {
        // Realiza la petición a la API
        const response = await fetch(API_URL);

        // Verifica si la respuesta es exitosa
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        // Parsea la respuesta JSON
        const data = await response.json();

        // Obtiene los elementos HTML donde mostraremos los precios
        const bitcoinElement = document.getElementById('bitcoinPrice');
        const ethereumElement = document.getElementById('ethereumPrice');
        const tetherElement = document.getElementById('tetherPrice');

        // Actualiza el contenido de los elementos HTML con los precios obtenidos
        // Asegúrate de que los IDs de las monedas y la estructura del JSON coincidan
        if (data.bitcoin && data.bitcoin.usd) {
            bitcoinElement.innerHTML = `<strong>Bitcoin (BTC):</strong> $${data.bitcoin.usd.toFixed(2)} USD`;
        } else {
            bitcoinElement.textContent = "Bitcoin: Precio no disponible";
        }

        if (data.ethereum && data.ethereum.usd) {
            ethereumElement.innerHTML = `<strong>Ethereum (ETH):</strong> $${data.ethereum.usd.toFixed(2)} USD`;
        } else {
            ethereumElement.textContent = "Ethereum: Precio no disponible";
        }

        if (data.tether && data.tether.usd) {
            tetherElement.innerHTML = `<strong>Tether (USDT):</strong> $${data.tether.usd.toFixed(4)} USD`; 
        } else {
            tetherElement.textContent = "Tether: Precio no disponible";
        }

    } catch (error) {
        console.error("Hubo un error al obtener los precios de las criptomonedas:", error);
        // Muestra un mensaje de error en la interfaz de usuario si algo falla
        document.getElementById('bitcoinPrice').textContent = "Error al cargar el precio de Bitcoin.";
        document.getElementById('ethereumPrice').textContent = "Error al cargar el precio de Ethereum.";
        document.getElementById('tetherPrice').textContent = "Error al cargar el precio de Tether.";
    }
}

// Ejecuta la función para obtener precios cuando el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', obtenerPreciosCripto);

// Opcional: Actualizar los precios cada cierto intervalo (por ejemplo, cada 60 segundos)
// CoinGecko tiene límites de tasa para su API gratuita, así que no hagas solicitudes demasiado frecuentes.
// setInterval(obtenerPreciosCripto, 60000); // 60000 milisegundos = 1 minuto