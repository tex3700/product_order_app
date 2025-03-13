<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    private array $validateRules = [
        'customer_name' => 'required|string|min:3|max:255',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1|max:1000',
        'comment' => 'nullable|string|max:1000',
    ];

    private array $rulesDescription = [
        'customer_name.min' => 'ФИО должно содержать не менее 3 символов',
        'quantity.min' => 'Минимальное количество - 1 шт',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $orders = Order::with('product')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Factory|View|Application
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->validateRules, $this->rulesDescription);

        $product = Product::find($request->product_id);

        Order::create([
            'customer_name' => $request->customer_name,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'status' => 'новый',
            'comment' => $request->comment,
        ]);

        return redirect()->route('orders.index');
    }

    public function updateStatus(Order $order): RedirectResponse
    {
        abort_if($order->status !== 'новый', 403);

        $order->update(['status' => 'выполнен']);
        return redirect()->back()
            ->with('success', 'Статус заказа изменен на "выполнен"');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order): Factory|View|Application
    {
        $order->load('product.category');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function edit(Order $order): Factory|View|Application
    {
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate($this->validateRules, $this->rulesDescription);

        $product = Product::findOrFail($validated['product_id']);

        $order->update([
            'customer_name' => $validated['customer_name'],
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $product->price * $validated['quantity'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Заказ успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Заказ успешно удален');
    }

}
