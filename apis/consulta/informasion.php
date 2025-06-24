<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../consulta/css/stilo.css">
    <title>Listado de Usuarios</title>
</head>
<body>
    <h1>Listado de Usuarios</h1>
    <div id="error" class="error" style="display: none;"></div>
    <table id="tabla-usuarios" style="display: none;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
            </tr>
        </thead>
        <tbody id="cuerpo-tabla">
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiUrl = 'tabla.php';

            const tablaElement = document.getElementById('tabla-usuarios');
            const cuerpoTabla = document.getElementById('cuerpo-tabla');

            // Petición para obtener los datos
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Verificar si hay datos
                    if (data.registros && data.registros.length > 0) {
                        // Mostrar tabla
                        tablaElement.style.display = 'table';
                        
                        data.registros.forEach(usuario => {
                            const fila = document.createElement('tr');
                            fila.innerHTML = `
                                <td>${usuario.id}</td>
                                <td>${usuario.nombre}</td>
                                <td>${usuario.apellidopaterno}</td>
                                <td>${usuario.apellidomaterno}</td>
                            `;
                            cuerpoTabla.appendChild(fila);
                        });
                    } else {
                        const fila = document.createElement('tr');
                        fila.innerHTML = `<td colspan="4">No se encontraron usuarios en la base de datos.</td>`;
                        cuerpoTabla.appendChild(fila);
                    }
                })
                .catch(error => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `<td colspan="4">Error al obtener los datos: ${error.message}</td>`;
                    cuerpoTabla.appendChild(fila);
                });
        });
    </script>
</body>
</html>