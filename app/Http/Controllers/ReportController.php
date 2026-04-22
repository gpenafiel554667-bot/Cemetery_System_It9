<?php

namespace App\Http\Controllers;

use App\Models\Deceased;
use App\Models\Lot;
use App\Models\Burial;
use App\Models\Payment;
use App\Models\Inquiry;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $totalDeceased = Deceased::count();
        $totalLots = Lot::count();
        $availableLots = Lot::where('status', 'available')->count();
        $occupiedLots = Lot::where('status', 'occupied')->count();
        $reservedLots = Lot::where('status', 'reserved')->count();
        $totalBurials = Burial::count();
        $totalPayments = Payment::sum('amount');
        $paidPayments = Payment::where('status', 'paid')->sum('amount');
        $unpaidPayments = Payment::where('status', 'unpaid')->sum('amount');
        $pendingInquiries = Inquiry::where('status', 'pending')->count();
        $totalInquiries = Inquiry::count();
        $totalUsers = User::count();
        $recentDeceased = Deceased::latest()->take(5)->get();
        $recentBurials = Burial::with(['deceased', 'lot'])->latest()->take(5)->get();
        $recentPayments = Payment::with('burial.deceased')->latest()->take(5)->get();

        return view('admin.reports', compact(
            'totalDeceased',
            'totalLots',
            'availableLots',
            'occupiedLots',
            'reservedLots',
            'totalBurials',
            'totalPayments',
            'paidPayments',
            'unpaidPayments',
            'pendingInquiries',
            'totalInquiries',
            'totalUsers',
            'recentDeceased',
            'recentBurials',
            'recentPayments'
        ));
    }

    public function exportPdf()
    {
        $totalDeceased = Deceased::count();
        $totalLots = Lot::count();
        $availableLots = Lot::where('status', 'available')->count();
        $occupiedLots = Lot::where('status', 'occupied')->count();
        $reservedLots = Lot::where('status', 'reserved')->count();
        $totalBurials = Burial::count();
        $totalPayments = Payment::sum('amount');
        $paidPayments = Payment::where('status', 'paid')->sum('amount');
        $unpaidPayments = Payment::where('status', 'unpaid')->sum('amount');
        $pendingInquiries = Inquiry::where('status', 'pending')->count();
        $totalInquiries = Inquiry::count();
        $totalUsers = User::count();
        $recentDeceased = Deceased::latest()->take(10)->get();
        $recentPayments = Payment::with('burial.deceased')->latest()->take(10)->get();

        $pdf = Pdf::loadView('admin.reports-pdf', compact(
            'totalDeceased',
            'totalLots',
            'availableLots',
            'occupiedLots',
            'reservedLots',
            'totalBurials',
            'totalPayments',
            'paidPayments',
            'unpaidPayments',
            'pendingInquiries',
            'totalInquiries',
            'totalUsers',
            'recentDeceased',
            'recentPayments'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Cemetery_Report_' . date('Y_m_d') . '.pdf');
    }
}