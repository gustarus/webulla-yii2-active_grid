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
 * Class ActiveInputColumn
 * @package wbl\active_grid\columns
 */
class ActiveInputColumn extends ActiveColumn {

	/**
	 * Тип инпута.
	 * @var string
	 */
	public $fieldType = 'text';


	/**
	 * @inheritdoc
	 */
	protected function renderDataCellContentField($field) {
		return $field->input($this->fieldType, $this->fieldOptions);
	}
}
