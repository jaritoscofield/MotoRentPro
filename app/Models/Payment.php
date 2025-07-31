<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'motorcycle_id',
        'sale_type', // 'venda', 'aluguel'
        'total_amount',
        'down_payment',
        'installments',
        'periodicity',
        'installment_amount',
        'payment_method',
        'status',
        'sale_date',
        'due_date',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'installment_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function installments()
    {
        return $this->hasMany(PaymentInstallment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFormattedTotalAmountAttribute()
    {
        return 'R$ ' . number_format($this->total_amount, 2, ',', '.');
    }

    public function getFormattedDownPaymentAttribute()
    {
        return 'R$ ' . number_format($this->down_payment, 2, ',', '.');
    }

    public function getFormattedInstallmentAmountAttribute()
    {
        return 'R$ ' . number_format($this->installment_amount, 2, ',', '.');
    }

    public function getFormattedSaleDateAttribute()
    {
        return $this->sale_date ? $this->sale_date->format('d/m/Y') : '-';
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? $this->due_date->format('d/m/Y') : '-';
    }

    public function getFormattedPaidAtAttribute()
    {
        return $this->paid_at ? $this->paid_at->format('d/m/Y H:i') : '-';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'ativa' => 'green',
            'concluida' => 'blue',
            'cancelada' => 'red',
            'pendente' => 'yellow',
            default => 'gray'
        };
    }

    public function getSaleTypeIconAttribute()
    {
        return match($this->sale_type) {
            'venda' => 'fas fa-shopping-cart',
            'aluguel' => 'fas fa-key',
            default => 'fas fa-money-bill'
        };
    }

    public function getPaymentMethodIconAttribute()
    {
        return match($this->payment_method) {
            'dinheiro' => 'fas fa-money-bill-wave',
            'cartao_credito' => 'fas fa-credit-card',
            'cartao_debito' => 'fas fa-credit-card',
            'pix' => 'fas fa-qrcode',
            'transferencia' => 'fas fa-university',
            default => 'fas fa-money-bill'
        };
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->total_amount <= 0) return 0;
        
        $paidAmount = $this->down_payment;
        if ($this->installments) {
            $paidAmount += $this->installments()->where('status', 'pago')->sum('amount');
        }
        
        return round(($paidAmount / $this->total_amount) * 100, 1);
    }

    public function getRemainingAmountAttribute()
    {
        $paidAmount = $this->down_payment;
        if ($this->installments) {
            $paidAmount += $this->installments()->where('status', 'pago')->sum('amount');
        }
        
        return $this->total_amount - $paidAmount;
    }

    public function getFormattedRemainingAmountAttribute()
    {
        return 'R$ ' . number_format($this->remaining_amount, 2, ',', '.');
    }

    public function getPaidAmountAttribute()
    {
        $paidAmount = $this->down_payment;
        if ($this->installments) {
            $paidAmount += $this->installments()->where('status', 'pago')->sum('amount');
        }
        return $paidAmount;
    }

    public function getFormattedPaidAmountAttribute()
    {
        return 'R$ ' . number_format($this->paid_amount, 2, ',', '.');
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'concluida';
    }

    public function getNextInstallmentAttribute()
    {
        return $this->installments()
            ->where('status', 'pendente')
            ->orderBy('due_date')
            ->first();
    }

    public function getOverdueInstallmentsAttribute()
    {
        return $this->installments()
            ->where('status', 'pendente')
            ->where('due_date', '<', now())
            ->get();
    }
} 