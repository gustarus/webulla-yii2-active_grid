<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace wbl\grid\columns;

use wbl\grid\columns\ActiveColumn;
use yii\helpers\Html;

/**
 * Class ActiveInputColumn
 * @package wbl\grid\columns
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
