<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cnh',
        'status',
        'total_rentals',
        'total_spent',
        'last_rental_date',
        'address',
        'birth_date',
        'notes'
    ];

    protected $casts = [
        'total_rentals' => 'integer',
        'total_spent' => 'decimal:2',
        'last_rental_date' => 'date',
        'birth_date' => 'date'
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Ativo' => 'green',
            'Inativo' => 'red',
            'Bloqueado' => 'orange',
            default => 'gray'
        };
    }

    public function getFormattedTotalSpentAttribute()
    {
        return 'R$ ' . number_format($this->total_spent, 2, ',', '.');
    }

    public function getFormattedLastRentalDateAttribute()
    {
        return $this->last_rental_date ? $this->last_rental_date->format('d/m/Y') : 'Nunca';
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d/m/Y') : 'N/A';
    }
} 