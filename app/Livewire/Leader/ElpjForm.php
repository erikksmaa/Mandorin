<?php

namespace App\Livewire\Leader;

use App\Models\FinancialItem;
use App\Models\FinancialReport;
use App\Models\Program;
use Livewire\Component;
use Livewire\WithFileUploads;

class ElpjForm extends Component
{
    use WithFileUploads;

    public Program $program;
    public ?FinancialReport $report = null;

    public $type = 'Expense';
    public $category = 'Transportasi';
    public $description = '';
    public $quantity = 1;
    public $unit_price = 0;
    public $transaction_date = '';
    public $receipt;

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::findOrFail($id);
        $this->transaction_date = now()->format('Y-m-d');

        $this->report = FinancialReport::firstOrCreate(
            ['program_id' => $this->program->id],
            [
                'total_budget' => $this->program->budget,
                'total_income' => 0,
                'total_expense' => 0,
                'remaining_budget' => $this->program->budget,
                'status' => 'Draft',
            ]
        );
    }

    public function addItem()
    {
        $this->validate([
            'description' => 'required|string|max:200',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'receipt' => $this->type === 'Expense' ? 'required|image|max:2048' : 'nullable|image|max:2048',
        ], [
            'receipt.required' => 'Bukti pembayaran wajib diunggah untuk pengeluaran.'
        ]);

        $subtotal = $this->quantity * $this->unit_price;
        $receiptPath = null;

        if ($this->receipt) {
            $receiptPath = $this->receipt->store('receipts', 'public');
        }

        FinancialItem::create([
            'financial_report_id' => $this->report->id,
            'type' => $this->type,
            'category' => $this->category,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'subtotal' => $subtotal,
            'receipt' => $receiptPath,
            'transaction_date' => $this->transaction_date,
        ]);

        $this->recalculateReport();
        $this->reset(['description', 'unit_price', 'receipt']);
        $this->quantity = 1;
        $this->dispatch('swal:success', message: 'Item transaksi berhasil ditambahkan!');
    }

    public function deleteItem($itemId)
    {
        FinancialItem::where('id', $itemId)->where('financial_report_id', $this->report->id)->delete();
        $this->recalculateReport();
        $this->dispatch('swal:success', message: 'Item laporan keuangan dihapus!');
    }

    public function submitElpj()
    {
        $this->report->update([
            'status' => 'Submitted',
            'submitted_at' => now(),
        ]);

        $this->dispatch('swal:success', message: 'E-LPJ berhasil diajukan ke Verifikator Dindikpora!');
    }

    private function recalculateReport()
    {
        $totalExpense = FinancialItem::where('financial_report_id', $this->report->id)
            ->where('type', 'Expense')
            ->sum('subtotal');

        $totalIncome = FinancialItem::where('financial_report_id', $this->report->id)
            ->where('type', 'Income')
            ->sum('subtotal');

        $remaining = $this->report->total_budget + $totalIncome - $totalExpense;

        $this->report->update([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'remaining_budget' => $remaining,
        ]);

        $this->report->refresh();
    }

    public function render()
    {
        $items = FinancialItem::where('financial_report_id', $this->report->id)->latest()->get();

        return view('livewire.leader.elpj-form', compact('items'))
            ->layout('layouts.app');
    }
}
