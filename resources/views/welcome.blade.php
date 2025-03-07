<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combinaciones de Colores Magic: The Gathering</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }

        h1 {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            margin: 0;
        }

        h2 {
            margin-top: 30px;
            font-size: 1.5em;
        }

        form {
            margin-top: 20px;
        }

        input {
            padding: 10px;
            margin: 5px;
            border: 2px solid #ddd;
            border-radius: 5px;
            width: 250px;
            font-size: 1em;
        }

        button {
            padding: 10px 15px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 5px;
            padding: 5px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 1.1em;
        }

        .result h3 {
            color: #4CAF50;
            margin-bottom: 3px;
        }

        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
        }

        .json-result {
            font-family: "Courier New", monospace;
            color: #333;
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }

        .legend {
            margin-top: 30px;
            font-size: 1.1em;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
        }

        .legend p {
            margin: 0;
        }
    </style>
</head>

<body>
    <h1>Combinaciones de Colores Magic: The Gathering</h1>
    <h2>Buscar por Colores</h2>
    <form id="findByColorForm">
        <input type="text" id="colors" placeholder="Ingresa colores (ej: W,U,R,B)" />
        <button type="submit">Obtener Combinación</button>
    </form>

    <h2>Buscar por Nombre</h2>
    <form id="findByNameForm">
        <input type="text" id="name" placeholder="Ingresa nombre combinación" />
        <button type="submit">Obtener Colores</button>
    </form>

    <div class="legend">
        <ul>
            <li><strong>Blanco/White</strong> - W</li>
            <li><strong>Azul/Blue</strong> - U</li>
            <li><strong>Negro/Black</strong> - B</li>
            <li><strong>Rojo/Red</strong> - R</li>
            <li><strong>Verde/Green</strong> - G</li>
        </ul>
    </div>

    <h2>Resultado:</h2>
    <pre id="result"></pre>


    <script>
        document.getElementById('findByColorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let colors = document.getElementById('colors').value.split(',').map(color => color.trim().toUpperCase());

            fetch(`/combination/by-colors?colors[]=${colors.join('&colors[]=')}`)
                .then(response => response.json())
                .then(data => {
                    let resultDiv = document.getElementById('result');
                    if (data.error) {
                        resultDiv.innerHTML = `<div class="error">${data.error}</div>`;
                    } else {
                        resultDiv.innerHTML = `
                            <h3>Combinación Encontrada:</h3>
                            <h3><strong>Nombre:</strong> ${data.name}</h3>
                            <h3><strong>Colores:</strong> ${data.colors.join(', ')}</h3>
                            <!-- <div class="json-result">${JSON.stringify(data, null, 2)}</div> -->
                        `;
                    }
                })
                .catch(error => {
                    let resultDiv = document.getElementById('result');
                    resultDiv.innerHTML = `<div class="error">Ocurrió un error. Intenta más tarde.</div>`;
                });
        });

        document.getElementById('findByNameForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let name = document.getElementById('name').value.trim();

            fetch(`/combination/by-name?name=${name}`)
                .then(response => response.json())
                .then(data => {
                    let resultDiv = document.getElementById('result');
                    if (data.error) {
                        resultDiv.innerHTML = `<div class="error">${data.error}</div>`;
                    } else {
                        resultDiv.innerHTML = `
                            <h3>Combinación Encontrada:</h3>
                            <h3><strong>Nombre:</strong> ${data.name}</h3>
                            <h3><strong>Colores:</strong> ${data.colors.join(', ')}</h3>
                            <!-- <div class="json-result">${JSON.stringify(data, null, 2)}</div> -->
                        `;
                    }
                })
                .catch(error => {
                    let resultDiv = document.getElementById('result');
                    resultDiv.innerHTML = `<div class="error">Ocurrió un error. Intenta más tarde.</div>`;
                });
        });
    </script>

</body>

</html>
