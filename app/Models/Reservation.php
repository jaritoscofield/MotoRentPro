<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'motorcycle_id',
        'start_date',
        'end_date',
        'daily_rate',
        'total_amount',
        'status',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'daily_rate' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Relacionamentos
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }

    // Accessors
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Ativa' => 'green',
            'Confirmada' => 'blue',
            'Pendente' => 'orange',
            'Concluída' => 'gray',
            'Cancelada' => 'red',
            default => 'gray'
        };
    }

    public function getFormattedTotalAmountAttribute()
    {
        return 'R$ ' . number_format($this->total_amount, 2, ',', '.');
    }

    public function getFormattedDailyRateAttribute()
    {
        return 'R$ ' . number_format($this->daily_rate, 2, ',', '.');
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('d/m/Y') : 'N/A';
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d/m/Y') : 'N/A';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y') : 'N/A';
    }

    public function getDurationDaysAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getPeriodTextAttribute()
    {
        $days = $this->duration_days;
        $dailyRate = $this->formatted_daily_rate;
        return "{$days} dias • {$dailyRate}/dia";
    }

    public function getDateRangeAttribute()
    {
        return "{$this->formatted_start_date} - {$this->formatted_end_date}";
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('start_date', today());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Ativa');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pendente');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'Confirmada');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Concluída');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }
} 