<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaymentInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'installment_number',
        'amount',
        'due_date',
        'status',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? $this->due_date->format('d/m/Y') : '-';
    }

    public function getFormattedPaidAtAttribute()
    {
        return $this->paid_at ? $this->paid_at->format('d/m/Y H:i') : '-';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pago' => 'green',
            'pendente' => 'yellow',
            'atrasado' => 'red',
            default => 'gray'
        };
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status === 'pendente';
    }

    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) return 0;
        return $this->due_date->diffInDays(now());
    }
} 