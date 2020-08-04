<?php
/**
 * @package     Mautic
 * @copyright   2020 Enguerr. All rights reserved
 * @author      Enguerr
 * @link        https://www.enguer.com
 * @license     GNU/AGPLv3 http://www.gnu.org/licenses/agpl.html
 */

namespace MauticPlugin\MauticBeefreeBundle\EventListener;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomAssetsEvent;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailEvent;
use Mautic\PageBundle\PageEvents;
use Mautic\PageBundle\Event\PageEvent;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticBeefreeBundle\Entity\BeefreeVersionRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class EventSubscriber implements EventSubscriberInterface
{
    /**
     * @var IntegrationHelper
     */
    private $integrationHelper;

    /**
     * @var BeefreeVersionRepository
     */
    private $beefreeVersionRepository;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        IntegrationHelper $integrationHelper,
        BeefreeVersionRepository $beefreeVersionRepository,
        RequestStack $requestStack
    ){
        $this->integrationHelper = $integrationHelper;
        $this->beefreeVersionRepository = $beefreeVersionRepository;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_ASSETS => ['injectAssets', -10],
            EmailEvents::EMAIL_POST_SAVE => ['saveEmailVersion',-20],
            PageEvents::PAGE_POST_SAVE => ['savePageVersion',-20],
        ];
    }

    /**
     * @param CustomAssetsEvent $assetsEvent
     */
    public function injectAssets(CustomAssetsEvent $assetsEvent)
    {
        $beefreeIntegration = $this->integrationHelper->getIntegrationObject('Beefree');
        if ($beefreeIntegration && $beefreeIntegration->getIntegrationSettings()->getIsPublished()) {
            $assetsEvent->addScript('plugins/MauticBeefreeBundle/Assets/js/builder.js');
        }
    }
    /**
     * @param CustomAssetsEvent $assetsEvent
     */
    public function saveEmailVersion(EmailEvent $emailEvent)
    {
        $json = $this->requestStack->getCurrentRequest()->get('beefree-template');
        $emailForm = $this->requestStack->getCurrentRequest()->get('emailform');
        $emailName = $emailForm['name'];
        $content = $emailForm['customHtml'];
        if (!empty($json)) {
            $this->beefreeVersionRepository->saveBeefreeVersion($emailName . ' - ' . date('d/m/Y H:i:s'), $content, $json, $emailEvent->getEmail()->getId(),'email');
        }
    }
    /**
     * @param CustomAssetsEvent $assetsEvent
     */
    public function savePageVersion(PageEvent $pageEvent)
    {
        $json = $this->requestStack->getCurrentRequest()->get('beefree-template');
        $pageForm = $this->requestStack->getCurrentRequest()->get('page');
        $pageName = $pageForm['title'];
        $content = $pageForm['customHtml'];
        if (!empty($json)) {
            $this->beefreeVersionRepository->saveBeefreeVersion($pageName . ' - ' . date('d/m/Y H:i:s'), $content, $json, $pageEvent->getPage()->getId(),'page');
        }
    }
}
