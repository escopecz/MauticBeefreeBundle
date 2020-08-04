<?php
/**
 * @package     Mautic
 * @copyright   2020 Enguerr. All rights reserved
 * @author      Enguerr
 * @link        https://www.enguer.com
 * @license     GNU/AGPLv3 http://www.gnu.org/licenses/agpl.html
 */

namespace MauticPlugin\MauticBeefreeBundle\Form\Type;

use Mautic\PageBundle\Form\Type\PageType as BasePageType;
use Symfony\Component\Form\FormBuilderInterface;
use Mautic\CoreBundle\Form\Type\FormButtonsType;

class PageType extends BasePageType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);

        $customButtons = [
            [
                'name'  => 'builder',
                'label' => 'mautic.core.builder',
                'attr'  => [
                    'class'   => 'btn btn-default btn-dnd btn-nospin text-primary btn-builder',
                    'icon'    => 'fa fa-cube',
                    'onclick' => "Mautic.launchBuilder('pageform', 'page');",
                ],
            ],
            [
                'name'  => 'builder_beefree',
                'label' => 'mautic.beefree.builder',
                'attr'  => [
                    'class'   => 'btn btn-default btn-dnd btn-nospin text-success btn-builder',
                    'icon'    => 'fa fa-beer',
                    'onclick' => "Mautic.launchCustomBuilder('pageform', 'page');",
                ],
            ],
        ];

        $builder->add(
            'buttons',
            FormButtonsType::class,
            [
                'pre_extra_buttons' => $customButtons,
            ]
        );
    }
}
