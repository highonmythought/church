<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExpensesExport;
use PDF; // barryvdh/laravel-dompdf
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create($data);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    public function show($id)
    {
         $expenses= Expense::find($id);
        return view('expenses.show', compact('expenses'));
    }

    public function edit($id)
{
    $expense = Expense::findOrFail($id);
    return view('expenses.edit', compact('expense'));
}

     public function update(Request $request, $id)
    {
        $expense =Expense::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $expense->update($data);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    public function summary(Request $request)
{
    $year = $request->input('year', now()->year);

    // Monthly totals (Jan to Dec)
    $monthlyExpenses = Expense::whereYear('expense_date', $year)
        ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

    $expenses = [];
    for ($m = 1; $m <= 12; $m++) {
        $expenses[] = $monthlyExpenses[$m] ?? 0;
    }

    // Totals
    $totalThisMonth = Expense::whereYear('expense_date', $year)
        ->whereMonth('expense_date', now()->month)
        ->sum('amount');

    $totalThisYear = Expense::whereYear('expense_date', $year)
        ->sum('amount');

    $totalAllTime = Expense::sum('amount');

    // Load detailed expenses safely (without category)
    $expensesDetails = Expense::whereYear('expense_date', $year)
        ->orderBy('expense_date', 'desc')
        ->get();

    return view('expenses.summary', compact(
        'expenses', 'totalThisMonth', 'totalThisYear', 'totalAllTime', 'year', 'expensesDetails'
    ));
}


    public function exportExcel(Request $request)
    {
        $year = $request->input('year', now()->year);
        return Excel::download(new ExpensesExport($year), "expenses_{$year}.xlsx");
    }

    public function exportPDF(Request $request)
    {
        $year = $request->input('year', now()->year);
        $expenses = Expense::whereYear('expense_date', $year)->get();
        $pdf = PDF::loadView('expenses.pdf', compact('expenses', 'year'));
        return $pdf->download("expenses_{$year}.pdf");
    }

    public function destroy($id)
{
    $expense = Expense::findOrFail($id);
    $expense->delete();

    return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
}

}
