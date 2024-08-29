<?php

declare(strict_types=1);

namespace Digiwerft\IsotopeLNbits\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Digiwerft\IsotopeLNbits\IsotopeLNbits;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(IsotopeLNbits::class)->setLoadAfter([ContaoCoreBundle::class, 'isotope'])
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): RouteCollection
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addCollection($resolver->resolve(__DIR__ . '/../Resources/config/routes.yaml')->load(__DIR__ . '/../Resources/config/routes.yaml'));
        return $routeCollection;
    }
}