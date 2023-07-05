<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Controller\Action;

use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusComparerPlugin\Context\ComparerContextInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;

final class ListComparerProductsAction
{
    public function __construct(
        private Environment $twig,
        private EntityManagerInterface $comparerManager,
        private ComparerContextInterface $comparerContext,
        private string $comparerCookieToken
    ) {
    }

    public function __invoke(Request $request): Response
    {
        /** @var ComparerInterface $comparer */
        $comparer = $this->comparerContext->getComparer($request);

        /** @var ProductInterface $product */
        $products = $comparer->getProducts();
        $attributes = $comparer->getComparerAttributes($products, $request->getLocale(), $request->getDefaultLocale());

        return new Response($this->twig->render(
                '@LocasticSyliusComparerPlugin/listComparer.html.twig', [
                    'products' => $comparer->getProducts(),
                    'attributes' => $attributes,
                ]
        ));
    }
}
