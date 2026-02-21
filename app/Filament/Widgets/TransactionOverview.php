<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transactions', Transaction::query()->count()),
            Stat::make('Total Amount (pending)', 'Rp.' . number_format(Transaction::query()->where('payment_status', 'pending')->sum('grandtotal'), 0, ',', '.')),
            Stat::make('Total Amount (paid)', 'Rp.' . number_format(Transaction::query()->where('payment_status', 'paid')->sum('grandtotal'), 0, ',', '.')),
        ];
    }
}
