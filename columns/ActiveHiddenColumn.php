<?php
/**
 * Created by PhpStorm.
 * User: supreme
 * Date: 03.05.14
 * Time: 23:06
 */

namespace wbl\active_grid\columns;

use wbl\active_grid\columns\ActiveColumn;
use yii\helpers\Html;

class ActiveHiddenColumn extends ActiveColumn {

	/**
	 * @inheritdoc
	 */
	public function renderHeaderCell() {
		return '';
	}

	/**
	 * @inheritdoc
	 */
	public function renderFilterCell() {
		return '';
	}

	/**
	 * @inheritdoc
	 */
	public function renderDataCell($model, $key, $index) {
		return Html::activeHiddenInput($model, '[' . $index . ']' . $this->attribute);
	}
}