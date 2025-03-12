<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colores Magic: The Gathering</title>
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
            padding: 10px;
            margin: 0;
        }

        h2 {
            margin-top: 10px;
            font-size: 1.5em;
        }

        h2 > img {
            width: 150px;
            height: 150px;
            margin: auto;
        }

        button > img {
            width: 50px;
            height: 50px;
            margin: auto;
            padding: 0;
        }

        form {
            margin-top: 10px;
        }

        input {
            padding: 10px;
            margin: 5px;
            border: 2px solid #ddd;
            border-radius: 5px;
            width: 250px;
            font-size: 1em;
        }

        /* button {
            padding: 10px 15px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        } */

        button:hover {
            background-color: #45a049;
        }

        .color-button {
            padding: 0px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .color-button:hover {
            opacity: 0.8;
        }

        .white {
            background-color: #ffffff;
            color: #000;
        }

        .blue {
            background-color: #1E90FF;
        }

        .black {
            background-color: #000000;
        }

        .red {
            background-color: #FF6347;
        }

        .green {
            background-color: #32CD32;
        }

        .result {
            margin-top: 2px;
            padding: 5px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 1.1em;
        }

        #result {
            margin-top: 30px;
            padding: 20px;
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
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 5px;
        }
    </style>
    {{-- PWA assets --}}
    @laravelPWA
</head>

<body>
    <h1>Colores Magic: The Gathering</h1>

    <h2>Selecciona los colores</h2>

    <!-- Color Buttons -->
    <div>
        <button class="color-button white" data-color="Blanco">
            <img src="/images/combinations/MonoWhite.png" alt="">
        </button>
        <button class="color-button blue" data-color="Azul">
            <img src="/images/combinations/MonoBlue.png" alt="">
        </button>
        <button class="color-button black" data-color="Negro">
            <img src="/images/combinations/MonoBlack.png" alt="">
        </button>
        <button class="color-button red" data-color="Rojo">
            <img src="/images/combinations/MonoRed.png" alt="">
        </button>
        <button class="color-button green" data-color="Verde">
            <img src="/images/combinations/MonoGreen.png" alt="">
        </button>
    </div>

    <h2>Buscar por Nombre</h2>
    <form id="findByNameForm">
        <input type="text" id="name" placeholder="Ingresa nombre combinación" />
        <button type="submit">Obtener Colores</button>
    </form>

    <h2>Resultado:</h2>
    <pre id="result"></pre>

    <script>

        //JS DEL BUSQUEDA POR SELECTOR DE COLOR
        // Variables para los botones
        const buttons = document.querySelectorAll('.color-button');
        const selectedColors = [];

        // Función para manejar los clics en los botones
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const color = this.dataset.color;

                // Añadir o quitar color de la lista seleccionada
                if (selectedColors.includes(color)) {
                    const index = selectedColors.indexOf(color);
                    selectedColors.splice(index, 1); // Eliminar el color de la lista
                    this.style.opacity = 1; // Vuelve a la opacidad normal
                } else {
                    selectedColors.push(color); // Agregar color a la lista
                    this.style.opacity = 0.1; // Marca el color como seleccionado
                }

                // Realizar la búsqueda de la combinación en el backend
                if (selectedColors.length > 0) {
                    fetch(`/combination/by-colors?colors[]=${selectedColors.join('&colors[]=')}`)
                        .then(response => response.json())
                        .then(data => {
                            const resultDiv = document.getElementById('result');
                            // const url = data.image_url;
                            if (data.error) {
                                resultDiv.innerHTML = `<div class="error">${data.error}</div>`;
                            } else {
                                resultDiv.innerHTML = `
                                    <h2><img src="${data.image_url}"/></h2>
                                    <h2><strong>Nombre:</strong> ${data.name} </h2>
                                    <h2><strong>Colores:</strong> ${data.colors.join(', ')}</h2>
                                `;
                            }
                        })
                        .catch(error => {
                            const resultDiv = document.getElementById('result');
                            resultDiv.innerHTML =
                                `<div class="error">Ocurrió un error, intenta nuevamente.</div>`;
                        });
                } else {
                    document.getElementById('result').innerHTML = ''; // Limpiar resultado
                }
            });
        });

        // JS DEL BUSQUEDA POR NOMBRE
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
                            <h2><img src="${data.image_url}"/></h2>
                            <h2><strong>Nombre:</strong> ${data.name}</h2>
                            <h2><strong>Colores:</strong> ${data.colors.join(', ')}</h2>
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
