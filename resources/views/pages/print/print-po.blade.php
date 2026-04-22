<!DOCTYPE html>
<html>
<head>
    <title>Print PO</title>
    <style>
        @page {
            size: A4;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .grand {
            font-weight: bold;
            background: #f3f3f3;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {

            body {
                margin: 0;
            }

            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 15mm;
                box-sizing: border-box;
                page-break-after: always;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }

            th, td {
                border: 1px solid #000;
                padding: 6px;
            }

            th {
                background: #eee;
            }

            .text-right { text-align: right; }
            .text-center { text-align: center; }

            .grand {
                font-weight: bold;
                background: #f3f3f3;
            }
        }
    </style>
</head>
<body>

@php
    $grandAll = 0;
    $rekap = [];
@endphp

@foreach ($plan->purchaseOrders->groupBy('date') as $date => $orders)

    @php $grandDaily = 0; @endphp

    <div class="header">
        <h1>SPPG CIAMIS PANJALU KERTAMANDALA 2</h1>
        <h2>PEMESANAN BAHAN BAKU</h2>
        <div>Periode: {{ $plan->start_date }} s/d {{ $plan->end_date }}</div>
        <div><strong>Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</strong></div>
    </div>

    <table>
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Kuantitas</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($orders as $order)
                @foreach ($order->items as $item)
                    @php $grandDaily += $item->grand_total; @endphp
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->material->name }}</td>
                        <td class="text-center">{{ $item->qty_display }}</td>
                        <td class="text-center">{{ $item->material->display_unit }}</td>
                        <td class="text-right">Rp {{ number_format($item->price) }}</td>
                        <td class="text-right">Rp {{ number_format($item->price * $item->qty_display) }}</td>
                    </tr>
                @endforeach
            @endforeach

            <tr class="grand">
                <td colspan="5" class="text-right">Grand Total Belanja Harian</td>
                <td class="text-right">Rp {{ number_format($grandDaily) }}</td>
            </tr>
        </tbody>
    </table>

    @php
        $rekap[$date] = $grandDaily;
        $grandAll += $grandDaily;
    @endphp

    <div class="page-break"></div>
@endforeach


{{-- REKAP --}}
<h2 style="text-align:center">REKAPITULASI BELANJA</h2>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Total Belanja</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rekap as $tgl => $total)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y') }}</td>
                <td class="text-right">Rp {{ number_format($total) }}</td>
            </tr>
        @endforeach

        <tr class="grand">
            <td class="text-right">TOTAL KESELURUHAN</td>
            <td class="text-right">Rp {{ number_format($grandAll) }}</td>
        </tr>
    </tbody>
</table>

<script>
    window.print();
</script>

</body>
</html>
