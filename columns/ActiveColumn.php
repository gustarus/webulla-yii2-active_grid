<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace wbl\grid\columns;

use wbl\grid\widgets\ActiveGrid;
use Yii;
use yii\db\ActiveRecord;
use yii\grid\DataColumn;
use yii\widgets\ActiveField;

/**
 * Class ActiveInputColumn
 * @package wbl\grid\columns
 */
class ActiveColumn extends DataColumn {

	/**
	 * @var ActiveGrid
	 */
	public $grid;

	/**
	 * Колбек для отрисовки инпута.
	 * @var callable
	 */
	public $fieldCallback = false;

	/**
	 * Настройки поля.
	 * @var
	 */
	public $fieldConfig = [
		'template' => "{input}\n{error}",
	];

	/**
	 * Html опции инпута.
	 * @var array
	 */
	public $fieldOptions = [];


	/**
	 * @inheritdoc
	 */
	protected function renderDataCellContent($model, $key, $index) {
		$field = $this->grid->form->field($model, '[' . $index . ']' . $this->attribute, $this->fieldConfig);

		return $this->renderDataCellContentField($field);
	}

	/**
	 * Рендерит поле.
	 * @param ActiveField $field
	 * @return string
	 */
	protected function renderDataCellContentField($field) {
		Yii::info('You must redefine ' . __METHOD__ . '.');

		return '';
	}
}
