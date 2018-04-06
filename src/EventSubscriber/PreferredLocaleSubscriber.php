<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PreferredLocaleSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var array
     */
    private $locales;

    /**
     * PreferredLocaleSubscriber constructor.
     * @param UrlGeneratorInterface $router
     * @param string $allowedLocalesPattern
     */
    public function __construct(UrlGeneratorInterface $router, string $allowedLocalesPattern)
    {
        $this->router = $router;
        $this->locales = explode('|', $allowedLocalesPattern);
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        $locale = $request->getPreferredLanguage($this->locales);

        /* The browser did not define any locale || could not read the locale from headers */
        if (null === $locale) {
            return;
        }

        /* Don't alter sub-requests */
        if (!$event->isMasterRequest()) {
            return;
        }

        /* Force the locale only for homepage */
        if ($request->getPathInfo() != '/') {
            return;
        }

        $homepage = $this->router->generate('homepage', ['_locale' => $locale]);
        $event->setResponse(RedirectResponse::create($homepage));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1024],
        ];
    }
}
