<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $invoices = Invoice::with(['company', 'payment'])->latest()->paginate(15)->withQueryString();
        return view('super-admin.invoices.index', compact('invoices'));
    }
}
