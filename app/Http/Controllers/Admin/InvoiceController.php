<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::with(['company', 'payment'])->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }
}
