@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Категория:</strong> {{ $product->category->name }}</p>
                <p><strong>Цена:</strong> {{ number_format($product->price, 2, '.', ' ') }} ₽</p>
                <p><strong>Описание:</strong> {{ $product->description ?? '—' }}</p>

                <a href="{{ route('products.index') }}" class="btn btn-secondary">Назад</a>
            </div>
        </div>
    </div>
@endsection
