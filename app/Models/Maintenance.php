<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'motorcycle_id',
        'type',
        'description',
        'scheduled_date',
        'completed_date',
        'cost',
        'status',
        'priority',
        'technician',
        'notes',
        'parts_used',
        'labor_hours',
        'next_maintenance_date',
        'mileage_at_service'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'cost' => 'decimal:2',
        'labor_hours' => 'decimal:1',
        'next_maintenance_date' => 'date',
        'mileage_at_service' => 'integer'
    ];

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Agendada' => 'blue',
            'Em Andamento' => 'orange',
            'Concluída' => 'green',
            'Cancelada' => 'red',
            'Atrasada' => 'red',
            default => 'gray'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'Baixa' => 'green',
            'Média' => 'yellow',
            'Alta' => 'red',
            'Crítica' => 'red',
            default => 'gray'
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'Preventiva' => 'fas fa-tools',
            'Corretiva' => 'fas fa-wrench',
            'Emergencial' => 'fas fa-exclamation-triangle',
            'Inspeção' => 'fas fa-search',
            'Revisão' => 'fas fa-cog',
            default => 'fas fa-tools'
        };
    }

    public function getFormattedCostAttribute()
    {
        return 'R$ ' . number_format($this->cost, 2, ',', '.');
    }

    public function getFormattedScheduledDateAttribute()
    {
        return $this->scheduled_date ? $this->scheduled_date->format('d/m/Y') : '-';
    }

    public function getFormattedCompletedDateAttribute()
    {
        return $this->completed_date ? $this->completed_date->format('d/m/Y') : '-';
    }

    public function getFormattedNextMaintenanceDateAttribute()
    {
        return $this->next_maintenance_date ? $this->next_maintenance_date->format('d/m/Y') : '-';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getDaysUntilScheduledAttribute()
    {
        if (!$this->scheduled_date) return null;
        
        $today = Carbon::today();
        return $this->scheduled_date->diffInDays($today, false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->scheduled_date && $this->scheduled_date->isPast() && $this->status !== 'Concluída';
    }

    public function getIsUpcomingAttribute()
    {
        return $this->scheduled_date && $this->scheduled_date->isFuture() && $this->status === 'Agendada';
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_date', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('scheduled_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('scheduled_date', Carbon::now()->month);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['Agendada', 'Em Andamento']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Concluída');
    }

    public function scopeOverdue($query)
    {
        return $query->where('scheduled_date', '<', Carbon::today())
                    ->whereNotIn('status', ['Concluída', 'Cancelada']);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>', Carbon::today())
                    ->where('status', 'Agendada');
    }
} 