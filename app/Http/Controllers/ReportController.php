<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);
        $type  = $request->get('type', 'stock-in');

        $stockIns = StockIn::with('product')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->latest()
            ->get();

        $stockOuts = StockOut::with('product')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->latest()
            ->get();

        $totalQtyIn  = $stockIns->sum('qty');
        $totalQtyOut = $stockOuts->sum('qty');

        $years = range(now()->year, now()->year - 4);

        $months = [
            1  => 'Januari',   2  => 'Februari', 3  => 'Maret',
            4  => 'April',     5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',   11 => 'November',  12 => 'Desember',
        ];

        return view('reports.index', compact(
            'stockIns', 'stockOuts',
            'totalQtyIn', 'totalQtyOut',
            'month', 'year', 'type',
            'months', 'years',
        ));
    }

    public function exportCsv(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);
        $type  = $request->get('type', 'stock-in');

        $months = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];

        $filename = ($type === 'stock-in' ? 'barang-masuk' : 'barang-keluar')
            . '-' . ($months[$month] ?? $month) . '-' . $year . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($type, $month, $year) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            if ($type === 'stock-in') {
                fputcsv($handle, ['No', 'Produk', 'Qty', 'Tanggal', 'Catatan']);

                $data = StockIn::with('product')
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->latest()
                    ->get();

                foreach ($data as $i => $row) {
                    fputcsv($handle, [
                        $i + 1,
                        $row->product->name ?? '-',
                        $row->qty,
                        $row->date,
                        $row->note ?? '-',
                    ]);
                }
            } else {
                fputcsv($handle, ['No', 'Produk', 'Qty', 'Tanggal', 'Catatan']);

                $data = StockOut::with('product')
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->latest()
                    ->get();

                foreach ($data as $i => $row) {
                    fputcsv($handle, [
                        $i + 1,
                        $row->product->name ?? '-',
                        $row->qty,
                        $row->date,
                        $row->note ?? '-',
                    ]);
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}