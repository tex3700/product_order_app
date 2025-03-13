@extends('layouts.app')

@section('title', 'Создание товара')

@section('content')
    <div class="container">
        <h1>Создание нового товара</h1>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Название товара *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Категория *</label>
                <select class="form-select @error('category_id') is-invalid @enderror"
                        id="category_id" name="category_id" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена (руб.) *</label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Создать товар</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
