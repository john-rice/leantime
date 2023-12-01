<?php

namespace Leantime\Domain\Plugins\Controllers;

use Leantime\Core\Controller;
use Leantime\Domain\Plugins\Services\Plugins as PluginService;
use Symfony\Component\HttpFoundation\Response;

class Details extends Controller
{
    /**
     * @var PluginService
     */
    private PluginService $pluginService;

    /**
     * @param PluginService $pluginService
     * @return void
     */
    public function init(PluginService $pluginService): void
    {
        $this->pluginService = $pluginService;
    }

    /**
     * @return Response
     */
    public function get(): Response
    {
        if (! $this->incomingRequest->query->has('id')) {
            throw new \Exception('Plugin Identifier is required');
        }

        /**
         * @var \Leantime\Domain\Plugins\Models\MarketplacePlugin[] $versions
         */
        $versions = $this->pluginService->getMarketplacePlugin(
            $this->incomingRequest->query->get('id'),
        );

        $this->tpl->assign('versions', $versions);

        return $this->tpl->display('plugins.plugindetails', 'blank');
    }
}
