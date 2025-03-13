@extends('layouts.app')

@section('title', 'Детали заказа')

@section('content')
    <div class="container">
        <h1>Заказ #{{ $order->id }}</h1>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Основная информация</h5>
                        <p><strong>Покупатель:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Статус:</strong>
                            <span class="badge bg-{{ $order->status === 'новый' ? 'primary' : 'success' }}">
                            {{ $order->status }}
                        </span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h5>Товар</h5>
                        <p><strong>Наименование:</strong> {{ $order->product->name }}</p>
                        <p><strong>Категория:</strong> {{ $order->product->category->name }}</p>
                        <p><strong>Количество:</strong> {{ $order->quantity }}</p>
                        <p><strong>Цена за единицу:</strong> {{ number_format($order->product->price, 2, '.', ' ') }} ₽</p>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Финансовая информация</h5>
                    <p class="fs-4 text-success">
                        Итого: {{ number_format($order->total_price, 2, '.', ' ') }} ₽
                    </p>
                </div>

                @if($order->comment)
                    <div class="mt-4">
                        <h5>Комментарий</h5>
                        <p class="text-muted">{{ $order->comment }}</p>
                    </div>
                @endif

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">
                        Редактировать
                    </a>

                    @if($order->status === 'новый')
                        <form action="{{ route('orders.complete', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                Отметить выполненным
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад</a>
                </div>
            </div>
        </div>
    </div>
@endsection
