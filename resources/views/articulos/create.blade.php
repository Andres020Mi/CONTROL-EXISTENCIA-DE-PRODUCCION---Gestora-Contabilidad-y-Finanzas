@extends('layouts.master')

@section('title')
    Crear Artículo
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
            display: none; /* Oculta la imagen por defecto */
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Artículo</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('articulos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required>

                    <label>Unidad de Medida:</label>
                    <select name="unidad_medida" required>
                        <option value="ml">ml</option>
                        <option value="kg">kg</option>
                        <option value="l">l</option>
                        <option value="g">g</option>
                    </select>

                    <label>Imagen:</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*">

                    <div class="image-preview">
                        <img id="imagePreview" alt="Vista previa de la imagen">
                    </div>

                    <button type="submit">Guardar</button>
                </form>
                <a href="{{ route('articulos.index') }}">Volver</a>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script>
        document.getElementById('imagen').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Muestra la imagen al cargar
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Oculta la imagen si no hay archivo
            }
        });
    </script>
@endsection