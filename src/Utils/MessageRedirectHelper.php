<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MessageRedirectHelper implements MessageRedirectHelperInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private UrlGeneratorInterface $urlGenerator,
        private TranslatorInterface $translator
    ) {
    }

    public function warningRedirect(string $messageTranslation, string $routeName): RedirectResponse
    {
        $this->requestStack->getSession()->getFlashBag()->add('error', $this->translator->trans($messageTranslation));

        return new RedirectResponse($this->urlGenerator->generate($routeName));
    }

    public function confirmationRedirect(string $messageTranslation, string $routeName): RedirectResponse
    {
        $this->requestStack->getSession()->getFlashBag()->add('success', $this->translator->trans($messageTranslation));

        return new RedirectResponse($this->urlGenerator->generate($routeName));
    }
}
