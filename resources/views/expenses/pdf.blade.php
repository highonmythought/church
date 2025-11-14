<!DOCTYPE html>
<html>
<head>
    <title>Expenses PDF - {{ $year }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #28a745; color: #fff; }
    </style>
</head>
<body>
    <h2>Expense Report - {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->title }}</td>
                <td>{{ $expense->description }}</td>
                <td>{{ number_format($expense->amount,2) }}</td>
                <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
