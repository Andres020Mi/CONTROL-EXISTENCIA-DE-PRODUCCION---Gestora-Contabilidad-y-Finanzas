@extends('layouts.master')

@section('title')
    Gestión de Existencias
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

.btn-success {
    background-color: #15803d;
    border-color: #15803d;
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    transition: background-color 0.15s ease-in-out;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.btn-success:hover {
    background-color: #166534;
    border-color: #166534;
}

.btn-warning {
    background-color: #ca8a04;
    border-color: #ca8a04;
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    transition: background-color 0.15s ease-in-out;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    min-width: 100px;
}

.btn-warning:hover {
    background-color: #a16207;
    border-color: #a16207;
}

.btn-danger {
    background-color: #b91c1c;
    border-color: #b91c1c;
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    transition: background-color 0.15s ease-in-out;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    min-width: 100px;
}

.btn-danger:hover {
    background-color: #991b1b;
    border-color: #991b1b;
}

.week-filter {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 0.25rem;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.week-filter label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #212529;
    margin-bottom: 0;
}

.week-filter input[type="week"] {
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    color: #495057;
    background-color: #fff;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.week-filter input[type="week"]:focus {
    border-color: #15803d;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25);
}

.week-filter button {
    background-color: #15803d;
    border-color: #15803d;
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    transition: background-color 0.15s ease-in-out;
    font-size: 0.875rem;
}

.week-filter button:hover {
    background-color: #166534;
    border-color: #166534;
}

.table-responsive {
    overflow-x: auto;
    min-width: 0;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    table-layout: auto;
}

.table thead th {
    background-color: #15803d;
    color: #fff;
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.5rem 0.3rem;
    vertical-align: middle;
    white-space: nowrap;
    text-align: center;
    border-right: 1px solid rgba(255, 255, 255, 0.2);
}

.table thead th:last-child {
    border-right: none;
}

.table tbody td {
    padding: 0.5rem 0.3rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #ffffff;
    background-color: #ffffff;
    text-align: center;
    font-size: 0.85rem;
    white-space: nowrap;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.actions {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.5rem;
    justify-content: center;
}

.thumbnail {
    max-width: 40px;
    max-height: 40px;
    border-radius: 0.25rem;
}

@media (max-width: 1200px) {
    .table thead th, .table tbody td {
        font-size: 0.7rem;
        padding: 0.4rem 0.2rem;
    }

    .thumbnail {
        max-width: 35px;
        max-height: 35px;
    }

    .btn-warning, .btn-danger {
        min-width: 90px;
        padding: 0.3rem 0.5rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 768px) {
    .actions {
        flex-direction: row;
        justify-content: flex-start;
        gap: 0.25rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .week-filter {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .btn-success, .btn-warning, .btn-danger {
        min-width: 80px;
        padding: 0.25rem 0.4rem;
        font-size: 0.7rem;
    }

    .thumbnail {
        max-width: 30px;
        max-height: 30px;
    }

    .table thead th, .table tbody td {
        font-size: 0.65rem;
        padding: 0.3rem 0.15rem;
    }
}

@media (max-width: 576px) {
    .table thead th, .table tbody td {
        font-size: 0.6rem;
        padding: 0.25rem 0.1rem;
    }

    .btn-warning, .btn-danger {
        min-width: 70px;
        padding: 0.2rem 0.3rem;
        font-size: 0.65rem;
    }

    .thumbnail {
        max-width: 25px;
        max-height: 25px;
    }
}
    </style>
    <link rel="stylesheet" href="{{ asset('DataTables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('DataTables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Agregar SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestión de Existencias</h3>
            </div>
            <div class="card-body">
                <!-- Formulario para seleccionar la semana -->
                <form method="GET" action="{{ route('articulos.index') }}" class="week-filter">
                    <label for="fecha">Filtrar por Semana:</label>
                    <input type="week" id="fecha" name="fecha" value="{{ $fechaSeleccionada }}" required>
                    <button type="submit">Aplicar</button>
                </form>

                <div class="mb-3">
                    <a href="{{ route('articulos.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Nuevo Artículo
                    </a>
                </div>

                 <div class="table-responsive">
              <table id="miTabla" class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio por unidad</th>
            <th>Inicial de semana</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th>Fin de semana</th>
            <th>Valor Ventas Semana</th>
            <th>Valor Stock Entradas Semana</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
  <tbody>
    @forelse ($articulos as $articulo)
        <tr>
            <td>{{ $articulo->id }}</td>
            <td>
                @if ($articulo->imagen)
                    <img src="{{ Storage::url($articulo->imagen) }}" alt="{{ $articulo->nombre }}" class="thumbnail">
                @else
                    Sin imagen
                @endif
            </td>
            <td>{{ $articulo->nombre }}</td>
            <td name="cops">$ {{ $articulo->precio_por_unidad }}</td>
            <td name="cops">{{ $articulo->cantidad_inicial }} {{ $articulo->unidad_medida }}</td>
            <td name="cops">{{ $articulo->entradas_semana }}</td>
            <td name="cops">{{ $articulo->salidas_semana }}</td>
            <td name="cops">{{ $articulo->cantidad_actual }} {{ $articulo->unidad_medida }}</td>
            <td name="cops">$ {{ $articulo->valor_ventas_semana }}</td>
            <td name="cops">$ {{ $articulo->valor_stock_entradas_semana }}</td>
            <td>{{ $articulo->fecha_actualizacion }}</td>
            <td class="actions">
                <a href="{{ route('articulos.edit', $articulo->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger delete-btn">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="12" style="text-align: center; padding: 20px;">
                <i class="fas fa-exclamation-circle"></i> No hay artículos disponibles
            </td>
        </tr>
    @endforelse
</tbody>
</table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scritps_end_body')
    <script src="{{ asset('DataTables/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('DataTables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('DataTables/jszip.min.js') }}"></script>
    <script src="{{ asset('DataTables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('DataTables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('DataTables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('DataTables/buttons.print.min.js') }}"></script>

    <!-- Inicialización de DataTables -->
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV' },
                    { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ entradas por página",
                    zeroRecords: "No se encontraron resultados",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "Sin registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [
                    { targets: 7, orderable: false } // Desactiva ordenación en "Acciones"
                ],
                initComplete: function() {
                    // Aplicar formato después de que DataTables renderice la tabla
                    window.applyNumberFormatting(['cops'], []);
                }
            });

            // Manejo de la eliminación con SweetAlert2
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres eliminar esta existencia? Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
     /**
 * Script reutilizable para formatear números con separadores de miles en elementos HTML.
 * Acepta listas de 'names' e 'ids' para identificar los elementos a formatear.
 * No depende de librerías externas ni de internet.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Función para formatear números con separadores de miles y preservar el símbolo $
    function formatNumberWithThousands(number, isMonetary = false) {
        // Convertir a número si es una cadena y manejar el símbolo $
        const num = typeof number === 'string' ? parseFloat(number.replace(/[^0-9.-]+/g, '')) : number;
        if (isNaN(num)) return isMonetary ? '$ 0' : '0'; // Manejar casos inválidos

        // Convertir a string con solo la parte entera (sin decimales)
        const integerPart = Math.floor(num).toString();
        // Agregar comas cada 3 dígitos en la parte entera
        let formattedInteger = '';
        const len = integerPart.length;
        for (let i = 0; i < len; i++) {
            if (i > 0 && (len - i) % 3 === 0) {
                formattedInteger += ',';
            }
            formattedInteger += integerPart[i];
        }
        // Devolver el número formateado, con $ si es monetario
        return isMonetary ? `$ ${formattedInteger}` : formattedInteger;
    }

    // Función para aplicar el formato a elementos por name o id
    function applyNumberFormatting(names = [], ids = []) {
        // Procesar elementos por 'name'
        names.forEach(name => {
            const elements = document.getElementsByName(name);
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                const value = element.textContent || element.innerText || element.value;
                const number = parseFloat(value.replace(/[^0-9.-]+/g, '')); // Extraer número
                if (!isNaN(number)) {
                    // Determinar si el elemento es monetario (contiene $ en el valor original)
                    const isMonetary = value.includes('$');
                    element.textContent = formatNumberWithThousands(number, isMonetary);
                }
            }
        });

        // Procesar elementos por 'id'
        ids.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const value = element.textContent || element.innerText || element.value;
                const number = parseFloat(value.replace(/[^0-9.-]+/g, '')); // Extraer número
                if (!isNaN(number)) {
                    const isMonetary = value.includes('$');
                    element.textContent = formatNumberWithThousands(number, isMonetary);
                }
            }
        });
    }

    // Exponer la función al ámbito global
    window.applyNumberFormatting = applyNumberFormatting;

    // Aplicar formato inicial (opcional, pero DataTables lo manejará en initComplete)
    // applyNumberFormatting(['cops'], []);
});
    </script>
@endsection