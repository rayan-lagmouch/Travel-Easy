<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { width: 100%; padding: 20px; border: 1px solid #ddd; }
        .title { font-size: 20px; font-weight: bold; }
        .details { margin-top: 10px; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
<div class="invoice-box">
    <h2 class="title">Invoice {{ $invoice->invoice_number }}</h2>
    <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Seat Number:</strong> {{ $invoice->booking->seat_number }}</p>
    <p><strong>Amount (excl. VAT):</strong> €{{ number_format($invoice->amount_ex_vat, 2) }}</p>
    <p><strong>VAT (21%):</strong> €{{ number_format($invoice->vat, 2) }}</p>
    <p><strong>Total (incl. VAT):</strong> €{{ number_format($invoice->amount_inc_vat, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->invoice_status) }}</p>

    <div class="footer">
        <p>Generated on {{ now()->format('d-m-Y H:i') }}</p>
    </div>
</div>
</body>
</html>
