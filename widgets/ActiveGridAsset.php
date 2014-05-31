<?php
/**
 * Created by PhpStorm.
 * User: supreme
 * Date: 03.05.14
 * Time: 20:56
 */

namespace wbl\active_grid\widgets;

use kartik\widgets\AssetBundle;

class ActiveGridAsset extends AssetBundle {

	/**
	 * @inheritdoc
	 */
	public $basePath = '@wbl/grid/assets';

	/**
	 * @inheritdoc
	 */
	public $baseUrl = '@web';

	/**
	 * @inheritdoc
	 */
	public $js = [
		'js/wblGridView.js',
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset',
	];
} 