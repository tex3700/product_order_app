@extends('layouts.app')

@section('title', 'Редактирование заказа')

@section('content')
    <div class="container">
        <h1>Редактирование заказа #{{ $order->id }}</h1>

        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Покупатель *</label>
                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                       name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                @error('customer_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Товар *</label>
                <select class="form-select @error('product_id') is-invalid @enderror" name="product_id" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id', $order->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ number_format($product->price, 2, '.', ' ') }} ₽)
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Количество *</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                       name="quantity" value="{{ old('quantity', $order->quantity) }}" min="1" required>
                @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Комментарий</label>
                <textarea class="form-control @error('comment') is-invalid @enderror"
                          name="comment" rows="3">{{ old('comment', $order->comment) }}</textarea>
                @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
