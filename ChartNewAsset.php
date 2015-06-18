<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace hscstudio\chart;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ChartNewAsset extends AssetBundle
{
    public $sourcePath = '@vendor/hscstudio/yii2-chart/ChartNew/';
    public $css = [
    ];
    public $js = [
        'ChartNew.js',
		'Add-ins\stats.js',
    ];
    public $depends = [
		'yii\bootstrap\BootstrapAsset',
    ];
}
