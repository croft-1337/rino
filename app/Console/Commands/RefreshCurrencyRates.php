<?php

namespace App\Console\Commands;

use App\Support\Currency\CurrencyRateService;
use App\Support\Currency\CurrencyService;
use Illuminate\Console\Command;
use Throwable;

class RefreshCurrencyRates extends Command
{
    protected $signature =
        'currency:refresh-rates';

    protected $description =
        'Refresh cached currency exchange rates';

    public function handle(
        CurrencyRateService $rates,
        CurrencyService $currency
    ): int {
        if (
            $currency->isManual()
        ) {
            $this->info(
                'Currency rates are in manual mode. Automatic refresh skipped.'
            );

            return self::SUCCESS;
        }

        $this->info(
            'Refreshing currency exchange rates...'
        );

        try {
            $result =
                $rates->refresh();
        } catch (
            Throwable $exception
        ) {
            $this->error(
                $exception->getMessage()
            );

            return self::FAILURE;
        }

        $rows = [];

        foreach (
            $result
            as $code => $rate
        ) {
            $rows[] = [
                $code,
                $rate,
            ];
        }

        $this->table(
            [
                'Currency',
                'Rate',
            ],
            $rows
        );

        $this->newLine();

        $this->info(
            'Currency rates refreshed successfully.'
        );

        return self::SUCCESS;
    }
}