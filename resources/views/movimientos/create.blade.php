@extends('layouts.master')

@section('title')
    Registrar Movimiento
@endsection

@section('links_css_head')
    <!-- Estilos personalizados -->
    <style>
        .content-wrapper {
            padding: 20px;
        }

        .card {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-header {
            background-color: #15803d;
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
        }

        .card-body {
            padding: 1.25rem;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #212529;
        }

        input, select {
            width: 100%;
            padding: 0.375rem 0.75rem;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input:focus, select:focus {
            border-color: #15803d;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25);
        }

        button {
            width: 100%;
            background-color: #15803d;
            border-color: #15803d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            transition: background-color 0.15s ease-in-out;
            cursor: pointer;
        }

        button:hover {
            background-color: #166534;
            border-color: #166534;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #15803d;
            font-size: 0.875rem;
        }

        a:hover {
            text-decoration: underline;
            color: #166534;
        }

        .image-preview {
            margin-bottom: 15px;
            text-align: center;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            display: none; /* Oculta por defecto */
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registrar Movimiento</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('movimientos.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="articulo_id">Existencias:</label>
                        <select name="articulo_id" id="articulo_id" required>
                            <option value="">Selecciona un Existencias</option>
                            @foreach ($articulos as $articulo)
                                <option 
                                    value="{{ $articulo->id }}" 
                                    data-image="{{ $articulo->imagen ? Storage::url($articulo->imagen) : '' }}"
                                    data-precio="{{ $articulo->precio_por_unidad }}"
                                >
                                    {{ $articulo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="image-preview">
                        <img id="imagePreview" alt="Vista previa del Existencias" style="display: none; max-width: 200px;">
                    </div>

                    <div>
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" min="1" required>
                    </div>

                    <div>
                        <label>Precio por Unidad:</label>
                        <p id="precioUnidad">$0.00</p>
                    </div>

                    <div>
                        <label>Monto Total:</label>
                        <p id="montoTotal" >$0.00</p>
                    </div>

                    <div>
                        <label for="tipo">Tipo:</label>
                        <select name="tipo" id="tipo" required>
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" required>
                    </div>

                    <button type="submit">Guardar</button>
                </form>
                <a href="{{ route('movimientos.index') }}">Volver</a>
            </div>
        </div>
    </div>

@endsection

@section('scritps_end_body')
    <script>
        const articuloSelect = document.getElementById('articulo_id');
        const cantidadInput = document.getElementById('cantidad');
        const precioUnidadDisplay = document.getElementById('precioUnidad');
        const montoTotalDisplay = document.getElementById('montoTotal');
        const imagePreview = document.getElementById('imagePreview');

        // Función para formatear números con separadores de miles
        function formatNumberWithThousands(number) {
            // Convertir a string con dos decimales
            const fixedNumber = number.toFixed(2);
            // Separar la parte entera y decimal
            const [integerPart, decimalPart] = fixedNumber.split('.');
            // Agregar comas cada 3 dígitos en la parte entera
            let formattedInteger = '';
            const len = integerPart.length;
            for (let i = 0; i < len; i++) {
                if (i > 0 && (len - i) % 3 === 0) {
                    formattedInteger += ',';
                }
                formattedInteger += integerPart[i];
            }
            // Combinar parte entera y decimal
            return `$${formattedInteger}.${decimalPart}`;
        }

        function updateCalculations() {
            // Evitar errores si no hay opción seleccionada
            const selectedOption = articuloSelect.selectedOptions[0];
            const precio = selectedOption && selectedOption.getAttribute('data-precio') ? parseFloat(selectedOption.getAttribute('data-precio')) : 0;
            const cantidad = cantidadInput.value ? parseInt(cantidadInput.value) : 0;

            // Actualizar precio por unidad con formato de miles
            precioUnidadDisplay.textContent = formatNumberWithThousands(precio);

            // Calcular y mostrar monto total con formato de miles
            const montoTotal = precio * cantidad;
            montoTotalDisplay.textContent = formatNumberWithThousands(montoTotal);
        }

        // Actualizar imagen y cálculos al cambiar el artículo
        articuloSelect.addEventListener('change', function(event) {
            const selectedOption = event.target.selectedOptions[0];
            const imageUrl = selectedOption ? selectedOption.getAttribute('data-image') : '';

            // Actualizar imagen
            if (imageUrl) {
                imagePreview.src = imageUrl;
                imagePreview.style.display = 'block';
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }

            // Actualizar cálculos
            updateCalculations();
        });

        // Actualizar cálculos al cambiar la cantidad
        cantidadInput.addEventListener('input', updateCalculations);

        // Inicializar cálculos al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            updateCalculations();
        });
    </script>
@endsection