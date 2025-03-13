
@extends('layouts.app')

@section('title', 'Список заказов')

@section('content')
    <div class="container">
        <h1 class="mb-4">Список заказов</h1>

        <div class="mb-3">
            <a href="{{ route('orders.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Создать новый заказ
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Покупатель</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $order->status === 'новый' ? 'primary' : 'success' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>{{ number_format($order->total_price, 2, '.', ' ') }} ₽</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Просмотр">Просмотр
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($order->status === 'новый')
                                    <form action="{{ route('orders.complete', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                title="Отметить выполненным"
                                                onclick="return confirm('Заказ будет отмечен как выполненный. Продолжить?')">
                                            Сменить статус
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Нет доступных заказов</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

{{--        @if($orders->hasPages())--}}
{{--            <div class="d-flex justify-content-center">--}}
{{--                {{ $orders->links() }}--}}
{{--            </div>--}}
{{--        @endif--}}
    </div>
@endsection
