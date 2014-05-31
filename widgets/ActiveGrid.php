<?php
/**
 * Created by PhpStorm.
 * User: supreme
 * Date: 02.05.14
 * Time: 1:02
 */

namespace wbl\active_grid\widgets;

use wbl\active_grid\assets\ActiveGridAsset;
use wbl\active_grid\columns\ActiveHiddenColumn;
use wbl\active_grid\columns\RowSelectColumn;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yii\grid\Column;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class ActiveGrid extends GridView {

	/**
	 * Прототип модели.
	 * @var ActiveRecord
	 */
	public $model;

	/**
	 * Модель формы.
	 * @var ActiveForm
	 */
	public $form;

	/**
	 * Список моделей для провайдера.
	 * @var
	 */
	public $models;

	/**
	 * @inheritdoc
	 */
	public $dataColumnClass = 'wbl\active_grid\columns\ActiveInputColumn';


	/**
	 * Возможность добавления записей.
	 * @var bool
	 */
	public $allowAdd = true;

	/**
	 * Возможность удаления записей.
	 * @var bool
	 */
	public $allowDelete = true;


	/**
	 * Вывести скрытую колонку с id моделей.
	 * @var bool
	 */
	public $enablePrimaryColumn = true;

	/**
	 * Вывести колонку с выбором строчек.
	 * @var bool
	 */
	public $enableSelectColumn = true;


	/**
	 * @inheritdoc
	 */
	public $tableOptions = ['class' => 'table table-striped table-active_grid'];

	/**
	 * @inheritdoc
	 */
	public $layout = "{items}\n{buttons}";

	/**
	 * @inheritdoc
	 */
	public $emptyText = 'It Is Found Nothing';

	/**
	 * @inheritdoc
	 */
	public $emptyTextOptions = ['class' => 'text-center'];


	/**
	 * Шаблон кнопок.
	 * @var string
	 */
	public $buttonsTemplate = '{add}&nbsp;{delete}';

	/**
	 * Опции отображенгия кнопок.
	 * @var array
	 */
	public $buttonsOptions = ['class' => 'clearfix text-center'];

	/**
	 * Прототип кнопки.
	 * @var array
	 */
	public $button = [
		'tag' => 'a',
		'content' => 'Link',
		'options' => []
	];

	/**
	 * Коллекция кнопок.
	 * @var array
	 */
	public $buttons = [
		'add' => [
			'tag' => 'a',
			'content' => 'Add',
			'options' => [
				'class' => 'btn btn-success',
				'href' => '#',
			]
		],

		'delete' => [
			'tag' => 'a',
			'content' => 'Delete',
			'options' => [
				'class' => 'btn btn-danger',
				'href' => '#',
			]
		]
	];


	/**
	 * @inheritdoc
	 */
	public function init() {
		// инициализация моделей
		if(is_array($this->models)) {
			$this->dataProvider = new ArrayDataProvider(['allModels' => $this->models]);
		}

		// добавляем скрытую колонку с id
		if($this->enablePrimaryColumn) {
			foreach($this->model->primaryKey() as $key) {
				$this->columns[] = [
					'class' => ActiveHiddenColumn::className(),
					'attribute' => $key
				];
			}
		}

		// добавляем колонку с чекбоксами
		if($this->enableSelectColumn) {
			$this->columns[] = [
				'class' => RowSelectColumn::className(),
			];
		}

		// инициализация кнопок
		if($this->buttons) {
			foreach($this->buttons as $name => &$button) {
				// id кнопки
				$button['options']['id'] = 'btn-' . $this->id . '-' . $name;

				// перевод кнопки
				if(is_string($button['content'])) {
					$button['content'] = Yii::t('app', $button['content']);
				}
			}
		}

		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		$id = $this->options['id'];

		ActiveGridAsset::register($this->getView());

		$options = [
			'emptyText' => Yii::t('app', $this->emptyText),
			'emptyTextOptions' => $this->emptyTextOptions,
			'rowTemplate' => $this->renderTableRowTemplate(),
		];

		$script = 'var $grid = $("#' . $id . '").ActiveGrid(' . json_encode($options) . ');';
		$this->allowAdd && $script .= '$grid.ActiveGrid("bindAddButton", "#' . $this->buttons['add']['options']['id'] . '");';
		$this->allowDelete && $script .= '$grid.ActiveGrid("bindDeleteButton", "#' . $this->buttons['delete']['options']['id'] . '");';

		$this->getView()->registerJs('(function(){' . $script . '})();');

		parent::run();
	}


	/**
	 * @inheritdoc
	 */
	public function renderSection($name) {
		switch($name) {
			case '{items}':
				return $this->renderItems();
			case '{buttons}':
				return $this->renderButtons();
			default:
				return false;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function renderTableBody() {
		$models = array_values($this->dataProvider->getModels());
		$keys = $this->dataProvider->getKeys();
		$rows = [];

		foreach($models as $index => $model) {
			$key = $keys[$index];
			$rows[] = $this->renderTableRow($model, $key, $index);
		}

		return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
	}

	/**
	 * Рендер шаблона строки таблицы.
	 * @return string
	 */
	public function renderTableRowTemplate() {
		return $this->renderTableRow($this->model, '#key#', '#index#');
	}

	/**
	 * Выполняет компиляцию кнопок.
	 * @return string
	 */
	public function renderButtons() {
		$buttons = [];
		foreach($this->buttons as $name => $button) {
			$button = array_merge($this->button, $button);
			$buttons['{' . $name . '}'] = Html::tag($button['tag'], $button['content'], $button['options']);
		}

		return Html::tag('div', strtr($this->buttonsTemplate, $buttons), $this->buttonsOptions);
	}
}