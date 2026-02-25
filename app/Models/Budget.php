<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = [
        'company_id', 'client_id', 'budget_number', 'client_name',
        'client_cpf_cnpj', 'client_address', 'status', 'valid_days',
        'discount_type', 'discount_sign', 'discount_value', 'notes', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'discount_value' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && auth()->user()->company_id) {
                $builder->where('budgets.company_id', auth()->user()->company_id);
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BudgetItem::class)->orderBy('sort_order');
    }

    public function getTotalAttribute(): float
    {
        $subtotal = $this->items->sum(fn ($item) => (float) $item->quantity * (float) $item->unit_price);

        if ($this->discount_sign === 'discount') {
            if ($this->discount_type === 'percent') {
                return $subtotal * (1 - (float) $this->discount_value / 100);
            }

            return max(0, $subtotal - (float) $this->discount_value);
        } else {
            if ($this->discount_type === 'percent') {
                return $subtotal * (1 + (float) $this->discount_value / 100);
            }

            return $subtotal + (float) $this->discount_value;
        }
    }

    public static function generateNumber(int $companyId): string
    {
        $year = now()->year;
        $count = static::withoutGlobalScopes()
            ->where('company_id', $companyId)
            ->whereYear('created_at', $year)
            ->count();

        return sprintf('ORÇ-%d-%03d', $year, $count + 1);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'    => 'Rascunho',
            'sent'     => 'Enviado',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'expired'  => 'Expirado',
            default    => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'    => 'gray',
            'sent'     => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'expired'  => 'yellow',
            default    => 'gray',
        };
    }
}
