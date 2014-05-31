<?php
/**
 * Created by PhpStorm.
 * User: supreme
 * Date: 03.05.14
 * Time: 14:55
 */

namespace wbl\active_grid\columns;

use Yii;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;

class RowSelectColumn extends CheckboxColumn {

	/**
	 * @inheritdoc
	 */
	public $checkboxOptions = [
		'class' => 'row-select form-control',
		'value' => true,
		'autocomplete' => 'off',
	];


	/**
	 * @inheritdoc
	 */
	public function renderHeaderCellContent() {
		$this->grid->view->registerJs('$("#' . $this->grid->id . '").ActiveGrid("getModel").setSelectionColumn("row-select");');

		return Html::checkbox('row-select', false, $this->checkboxOptions);
	}

	/**
	 * @inheritdoc
	 */
	public function renderDataCellContent($model, $key, $index) {
		return Html::checkbox('row-select', false, $this->checkboxOptions);
	}
}