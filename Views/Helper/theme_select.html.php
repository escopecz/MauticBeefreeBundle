<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
$codeMode   = 'mautic_code_mode';
$isCodeMode = ($active == $codeMode);
?>
<?php if ($bfthemes) : ?>
    <div class="row">
        <div class="col-md-3 beefree-theme-list">
            <div class="panel panel-default <?php echo $isCodeMode ? 'beefree-selected' : ''; ?>">
                <div class="panel-body text-center">
                    <h3><?php echo $view['translator']->trans('mautic.beefree.from-scratch'); ?></h3>
                    <div class="panel-body text-center" style="height: 225px">
                        <i class="fa fa-file fa-5x text-muted" aria-hidden="true" style="padding-top: 50px; color: #E4E4E4;"></i>
                    </div>
                    <a href="#" type="button" data-theme-beefree="new" class="select-theme-link btn btn-default btn-dnd btn-nospin text-success btn-builder btn-copy <?php echo $isCodeMode ? 'hide' : '' ?>" onclick="mQuery('#dynamic-content-tab').removeClass('hidden')">
                        <i class="fa fa-beer "></i>
                        <?php echo $view['translator']->trans('mautic.beefree.from-scratch'); ?>
                    </a>
                    <button type="button" class="select-theme-selected btn btn-default <?php echo $isCodeMode ? '' : 'hide' ?>" disabled="disabled">
                        Editing
                    </button>
                </div>
            </div>
        </div>
        <?php foreach ($bfthemes as $themeInfo) : ?>

            <?php
                $themeKey = $themeInfo->getName();
                $isSelected = ($active === $themeKey);
            ?>

            <?php
                $thumbnailName = 'thumbnail_'.$type.'.png';
                $hasThumbnail  = true;
            ?>
            <?php $thumbnailUrl = '';//$view['assets']->getUrl($themeInfo['themesLocalDir'].'/'.$themeKey.'/'.$thumbnailName); ?>
            <div class="col-md-3 beefree-theme-list">
                <div class="panel panel-default <?php echo $isSelected ? 'beefree-selected' : ''; ?>">
                    <div class="panel-body text-center">
                        <h3><?php echo $themeInfo->getName(); ?></h3>
                        <?php if ($hasThumbnail) : ?>
                            <a href="#" data-toggle="modal" data-target="#theme-<?php echo $themeKey; ?>">
                                <div style="background-image: url('data:image/gif;base64,<?php echo base64_encode($themeInfo->getPreview()); ?>');background-repeat:no-repeat;background-size:contain; background-position:center; width: 100%; height: 250px"></div>
                            </a>
                        <?php else : ?>
                            <div class="panel-body text-center" style="height: 250px">
                                <i class="fa fa-file-image-o fa-5x text-muted" aria-hidden="true" style="padding-top: 75px; color: #E4E4E4;"></i>
                            </div>
                        <?php endif; ?>
                        <a href="#" type="button" data-theme-beefree="<?php echo $themeKey; ?>" class="select-theme-link btn btn-default btn-dnd btn-nospin text-success btn-builder btn-copy " onclick="Mautic.launchCustomBuilder('emailform', 'email',this);">
                            <i class="fa fa-beer "></i>
                            <?php echo $view['translator']->trans('mautic.beefree.builder'); ?>
                        </a>
                        <button type="button" class="select-theme-selected btn btn-default  btn-dnd btn-nospin text-success btn-builder btn-copy <?php echo $isSelected ? '' : 'hide' ?>" >
                            <i class="fa fa-beer "></i>
                            <?php echo $view['translator']->trans('mautic.beefree.builder'); ?>
                        </button>
                    </div>
                </div>
                <?php if ($hasThumbnail) : ?>
                    <!-- Modal -->
                    <div class="modal fade" id="theme-<?php echo $themeKey; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $themeKey; ?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="<?php echo $themeKey; ?>"><?php echo $themeInfo->getName(); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <div style="background-image: url(<?php echo $thumbnailUrl ?>);background-repeat:no-repeat;background-size:contain; background-position:center; width: 100%; height: 600px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>