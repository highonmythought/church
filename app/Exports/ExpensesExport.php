<?php

namespace App\Exports;


use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpensesExport implements FromCollection, WithHeadings
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        return Expense::whereYear('expense_date', $this->year)
            ->select('title','description','amount','expense_date')
            ->get();
    }

    public function headings(): array
    {
        return ['Title', 'Description', 'Amount', 'Expense Date'];
    }
}
