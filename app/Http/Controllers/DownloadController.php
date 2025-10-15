<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display user's purchased products
     */
    public function index()
    {
        $orders = Order::with(['orderable'])
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('downloads.index', compact('orders'));
    }

    /**
     * Download a purchased product
     */
    public function download(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if the order is completed
        if ($order->status !== 'completed') {
            abort(403, 'Order not completed');
        }

        $product = $order->orderable;

        // Check if the product has a file to download
        if (!$product->file_path) {
            abort(404, 'Download file not found');
        }

        // Generate a secure download link or serve the file
        $filePath = storage_path('app/private/' . $product->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Log the download
        \App\Models\DownloadLog::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return response()->download($filePath, $product->name . '.zip');
    }
}