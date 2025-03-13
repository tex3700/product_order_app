
@extends('layouts.app')

@section('title', 'Создание нового заказа')

@section('content')
    <div class="container">
        <h1>Создание нового заказа</h1>

        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf

            <div class="card mb-4">
                <div class="card-body">
                    <!-- Покупатель -->
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">ФИО покупателя *</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                               id="customer_name" name="customer_name"
                               value="{{ old('customer_name') }}" required>
                        @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Выбор товара -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Товар *</label>
                        <select class="form-select @error('product_id') is-invalid @enderror"
                                id="product_id" name="product_id" required>
                            <option value="">Выберите товар</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - {{ number_format($product->price, 2, '.', ' ') }} ₽
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Количество -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Количество *</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                               id="quantity" name="quantity"
                               value="{{ old('quantity', 1) }}"
                               min="1" max="1000" required>
                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Итоговая цена -->
                    <div class="mb-3">
                        <label class="form-label">Итоговая цена</label>
                        <div class="form-control-plaintext fw-bold" id="totalPrice">
                            0.00 ₽
                        </div>
                    </div>
                </div>
            </div>

            <!-- Комментарий -->
            <div class="mb-4">
                <label for="comment" class="form-label">Комментарий</label>
                <textarea class="form-control @error('comment') is-invalid @enderror"
                          id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Создать заказ</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function calculateTotal() {
            const price = parseFloat(document.querySelector('#product_id option:checked')?.dataset.price) || 0;
            const quantity = parseInt(document.querySelector('#quantity').value) || 0;
            const total = (price * quantity).toFixed(2);
            document.querySelector('#totalPrice').textContent = `${total} ₽`;
        }

        document.querySelector('#product_id').addEventListener('change', calculateTotal);
        document.querySelector('#quantity').addEventListener('input', calculateTotal);

        calculateTotal();
    </script>
@endsection
