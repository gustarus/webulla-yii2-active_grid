<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace wbl\active_grid\columns;

/**
 * Class ActiveWidgetColumn
 * @package wbl\active_grid\columns
 */
class ActiveWidgetColumn extends ActiveColumn {

	/**
	 * Настройки виджета.
	 * @var array
	 */
	public $widgetConfig;


	/**
	 * @inheritdoc
	 */
	protected function renderDataCellContentField($field) {
		return $field->widget($this->widgetConfig);
	}
}
