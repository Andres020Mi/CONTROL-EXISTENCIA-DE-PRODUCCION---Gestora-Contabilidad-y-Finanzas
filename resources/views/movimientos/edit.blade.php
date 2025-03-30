@extends('layouts.master')

@section('title')
    Editar Movimiento
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
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Movimiento</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('movimientos.update', $movimiento->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label>Existencia:</label>
                    <select name="articulo_id" id="articulo_id" required>
                        <option value="">Selecciona una existencia</option>
                        @foreach ($articulos as $articulo)
                            <option value="{{ $articulo->id }}" {{ $movimiento->articulo_id == $articulo->id ? 'selected' : '' }} data-image="{{ $articulo->imagen ? Storage::url($articulo->imagen) : '' }}">{{ $articulo->nombre }}</option>
                        @endforeach
                    </select>

                    <div class="image-preview">
                        <img id="imagePreview" src="{{ $movimiento->articulo && $movimiento->articulo->imagen ? Storage::url($movimiento->articulo->imagen) : '' }}" alt="Vista previa del artículo" style="display: {{ $movimiento->articulo && $movimiento->articulo->imagen ? 'block' : 'none' }};">
                    </div>

                    <label>Cantidad:</label>
                    <input type="number" name="cantidad" value="{{ $movimiento->cantidad }}" min="1" required>

                    <label>Tipo:</label>
                    <select name="tipo" required>
                        <option value="entrada" {{ $movimiento->tipo == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ $movimiento->tipo == 'salida' ? 'selected' : '' }}>Salida</option>
                    </select>

                    <label>Fecha:</label>
                    <input type="date" name="fecha" value="{{ $movimiento->fecha->format('Y-m-d') }}" required>

                    <button type="submit">Actualizar</button>
                </form>
                <a href="{{ route('movimientos.index') }}">Volver</a>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script>
        document.getElementById('articulo_id').addEventListener('change', function(event) {
            const selectedOption = event.target.selectedOptions[0];
            const imageUrl = selectedOption.getAttribute('data-image');
            const preview = document.getElementById('imagePreview');

            if (imageUrl) {
                preview.src = imageUrl;
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>
@endsection