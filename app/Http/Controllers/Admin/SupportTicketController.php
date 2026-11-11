<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    public function index(): View
    {
        $tickets = SupportTicket::with(['company', 'user'])->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }
}
