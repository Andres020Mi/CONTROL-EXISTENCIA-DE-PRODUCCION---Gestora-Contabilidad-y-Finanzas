@extends('layouts.app')
@section('header')
    Editar articulo
@endsection

@section('content')
<h2>Editar Artículo</h2>
<form action="{{ route('articulos.update', $articulo->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre:</label>
    <input type="text" name="nombre" value="{{ $articulo->nombre }}" required>

    <label>Unidad de Medida:</label>
    <select name="unidad_medida" required>
        <option value="ml" {{ $articulo->unidad_medida == 'ml' ? 'selected' : '' }}>ml</option>
        <option value="kg" {{ $articulo->unidad_medida == 'kg' ? 'selected' : '' }}>kg</option>
        <option value="l" {{ $articulo->unidad_medida == 'l' ? 'selected' : '' }}>l</option>
        <option value="g" {{ $articulo->unidad_medida == 'g' ? 'selected' : '' }}>g</option>
    </select>

    <label>Cantidad Inicial:</label>
    <input type="number" name="cantidad_inicial" value="{{ $articulo->cantidad_inicial }}" required>

    <button type="submit">Actualizar</button>
</form>
<a href="{{ route('articulos.index') }}">Volver</a>
@endsection
