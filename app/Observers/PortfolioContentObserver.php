<?php

namespace App\Observers;

use App\Services\PortfolioContent;
use Illuminate\Database\Eloquent\Model;

class PortfolioContentObserver
{
    public function saved(Model $model): void
    {
        PortfolioContent::flush();
    }

    public function deleted(Model $model): void
    {
        PortfolioContent::flush();
    }
}
