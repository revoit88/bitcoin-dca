<?php

declare(strict_types=1);

namespace Jorijn\Bitcoin\Dca\Service;

use Jorijn\Bitcoin\Dca\Exception\NoExchangeAvailableException;

class BalanceService
{
    /** @var BalanceServiceInterface[] */
    protected iterable $registeredServices;
    protected string $configuredExchange;

    public function __construct(iterable $registeredServices, string $configuredExchange)
    {
        $this->registeredServices = $registeredServices;
        $this->configuredExchange = $configuredExchange;
    }

    public function getBalances(): array
    {
        foreach ($this->registeredServices as $registeredService) {
            if ($registeredService->supportsExchange($this->configuredExchange)) {
                return $registeredService->getBalances();
            }
        }

        throw new NoExchangeAvailableException('no exchange was available to provide balances');
    }
}
