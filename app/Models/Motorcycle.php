<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_plate',
        'year',
        'status',
        'rating',
        'tags',
        'category',
        'fuel',
        'mileage',
        'daily_rate',
        'total_rentals',
        'image',
        'description'
    ];

    protected $casts = [
        'tags' => 'array',
        'rating' => 'decimal:1',
        'daily_rate' => 'decimal:2',
        'mileage' => 'integer',
        'total_rentals' => 'integer',
        'year' => 'integer'
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Disponível' => 'green',
            'Alugada' => 'blue',
            'Manutenção' => 'orange',
            'Inativa' => 'red',
            default => 'gray'
        };
    }

    public function getCategoryIconAttribute()
    {
        return match($this->category) {
            'Urbana' => 'fas fa-city',
            'Esportiva' => 'fas fa-motorcycle',
            'Custom' => 'fas fa-motorcycle',
            'Trail' => 'fas fa-mountain',
            default => 'fas fa-motorcycle'
        };
    }

    public function getFuelIconAttribute()
    {
        return match($this->fuel) {
            'Flex' => 'fas fa-gas-pump',
            'Gasolina' => 'fas fa-gas-pump',
            'Elétrica' => 'fas fa-bolt',
            'Híbrida' => 'fas fa-leaf',
            default => 'fas fa-gas-pump'
        };
    }

    public function getFormattedMileageAttribute()
    {
        return number_format($this->mileage, 0, ',', '.') . ' km';
    }

    public function getFormattedDailyRateAttribute()
    {
        return 'R$ ' . number_format($this->daily_rate, 2, ',', '.');
    }
} 