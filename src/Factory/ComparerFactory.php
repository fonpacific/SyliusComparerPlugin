<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Utils\ComparerTokenInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ComparerFactory implements ComparerFactoryInterface
{
    public function __construct(
        private FactoryInterface $comparerFactory,
        private ComparerTokenInterface $comparerToken
    ) {
    }

    public function createNew(): ComparerInterface
    {
        /** @var ComparerInterface $comparer */
        $comparer = $this->comparerFactory->createNew();
        $comparer->setToken($this->comparerToken->provide());

        return $comparer;
    }

    public function createForShopUser(ShopUserInterface $shopUser): ComparerInterface
    {
        $comparer = $this->createNew();

        $comparer->setShopUser($shopUser);

        return $comparer;
    }
}
