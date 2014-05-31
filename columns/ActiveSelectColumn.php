<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace wbl\active_grid\columns;

use wbl\active_grid\columns\ActiveColumn;
use yii\helpers\Html;

/**
 * Class ActiveSelectColumn
 * @package wbl\active_grid\columns
 */
class ActiveSelectColumn extends ActiveColumn {

	/**
	 * Данные списка.
	 * @var array
	 */
	public $fieldData = [];


	/**
	 * @inheritdoc
	 */
	protected function renderDataCellContentField($field) {
		return $field->dropDownList($this->fieldData, $this->fieldOptions);
	}
}
