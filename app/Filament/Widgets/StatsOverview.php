<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // % of user
        $totalUsers = User::count();
        $usersWithRoles = User::whereHas('roles')->count();
        $percentageWithRoles = $totalUsers > 0 ? ($usersWithRoles / $totalUsers) * 100 : 0;
        $percentageWithRolesFormatted = number_format($percentageWithRoles, 2);
        $color = $percentageWithRoles < 50 ? 'danger' : 'success';

        // Generate chart data for new inventories over time
        $inventoryData = Inventory::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->pluck('count', 'date')
        ->toArray();

        return [
            Stat::make('Total User', User::count())
                ->description('Users in This System')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make('Users with Roles', "{$percentageWithRolesFormatted}%")
                ->description('Percentage of users with roles')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color($color),
            Stat::make('Total Inventory', Inventory::count())
                ->description('Inventories had been taken')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart(array_values($inventoryData))
                ->color('success'),
            Stat::make('Total Category', Category::count())
                ->description('Had Categories')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),
        ];
    }
}