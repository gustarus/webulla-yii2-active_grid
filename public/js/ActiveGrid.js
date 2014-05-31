/**
 * Created by:  Pavel Kondratenko.
 * Created at:  03.05.14 20:19
 * Email:       gustarus@gmail.com
 * Web:         http://webulla.ru
 */

(function ($) {
	// опции по умолчанию
	var defaults = {
		selectionColumn: undefined,
		emptyText: undefined,
		emptyTextOptions: undefined,
		rowTemplate: undefined
	};


	/**
	 * Плагин.
	 * @param method
	 * @returns {*}
	 */
	$.fn.ActiveGrid = function (method) {
		// получаем модель таблицы
		var model;
		if (typeof method == 'undefined' || typeof method == 'object') {
			model = new window.ActiveGrid($.extend({el: this}, method || {}));
			this.data('WblGrid', model);
		} else {
			model = this.data('WblGrid');
			if(!model) {
				$.error('[jQuery.ActiveGrid] Model ActiveGrid does not exist in $.data.');
			}else if (!model[method]) {
				$.error('[jQuery.ActiveGrid] Method ' + method + ' does not exist in ActiveGrid model.');
			} else {
				return model[method].apply(model, Array.prototype.slice.call(arguments, 1));
			}
		}

		return this;
	};


	/**
	 * Модель таблицы.
	 * @param options
	 * @constructor
	 */
	window.ActiveGrid = function (options) {
		var that = this;

		/**
		 * Вызывается в конце создания модели.
		 */
		this.setup = function () {
			// установка элемента таблицы
			if (options.el) {
				that.$el = options.el instanceof $ ? options.el : $(options.el);
				that.el = that.$el[0];
				delete(options.el);
			}

			// заглушка для пустой таблицы
			that.$empty = $('<tr><td colspan="' + that.getColsCount() + '">' + options.emptyText + '</td></tr>');
			that.$empty.attr(options.emptyTextOptions).hide();
			that.addHeadRow(that.$empty);

			that.options = options;

			that.refresh();
		};


		/**
		 * @returns {Grid}
		 */
		this.getModel = function () {
			return that;
		};


		/**
		 * Возвращает бокс из шапки таблицы.
		 */
		this.getHeaderSelectionBox = function () {
			return that.$el.find('th ' + that.options.checkboxes);
		};

		/**
		 * Возвращает бокс из тела таблицы.
		 */
		this.getSelectionBox = function () {
			return that.$el.find('td ' + that.options.checkboxes);
		};


		/**
		 * Добавляет строку в шапку.
		 * @param row
		 */
		this.addHeadRow = function (row) {
			that.$el.find('thead').append(row);
		};

		/**
		 * Получает строки из шапки.
		 * @returns {*}
		 */
		this.getHeadRows = function () {
			return that.$el.find('thead tr');
		};


		/**
		 * Добавляет строку в тело.
		 * @param row
		 */
		this.addRow = function (row) {
			that.$el.find('tbody').append(row);
		};

		/**
		 * Возвращает строки из тела.
		 * @returns {*}
		 */
		this.getRows = function () {
			return that.$el.find('tbody tr');
		};


		/**
		 * Привязывает кнопку "Добавить".
		 * @param dom
		 */
		this.bindAddButton = function (dom) {
			// [событие] добавление строки
			var i = that.getRows().length - 1;
			$(dom).on('click', function () {
				i++;
				that.addRow(that.options.rowTemplate.replace(/#index#/g, i));
				that.refresh();
			});
		};

		/**
		 * Привязывает кнопку "Удалить".
		 * @param dom
		 */
		this.bindDeleteButton = function (dom) {
			// [событие] удаление строк
			$(dom).on('click', function () {
				that.getSelectedRows().remove();
				that.refresh();
			});
		};


		/**
		 * Обновляем таблицу.
		 */
		this.refresh = function () {
			// находим все боксы
			var $boxes = that.getSelectionBox();

			// обновляем состояние бокса в шапке
			that.$box && that.$box.prop('checked', $boxes.length && $boxes.length == $boxes.filter(':checked').length);

			// проверяем наличие строк
			that.getRows().length ? that.$empty.hide() : that.$empty.show();
		};

		/**
		 * Возвращает количество строк.
		 * @returns {int}
		 */
		this.getColsCount = function () {
			return that.getRows().first().find('td').length;
		};

		/**
		 * Возвращает выбранные строки.
		 * @returns {*}
		 */
		this.getSelectedRows = function () {
			return that.getSelectionBox().filter(':checked').closest('tr');
		};

		/**
		 * Установка колонки для выбора строк.
		 * @param name
		 */
		this.setSelectionColumn = function (name) {
			// селектор для поиска чекбоксов выбора строки
			that.options.checkboxes = 'input[name="' + name + '"]';

			// находим чекбокс в шапке
			that.$box = that.getHeaderSelectionBox();

			// [событие] клик по чекбоксу в шапке
			that.$box.on('change', function () {
				that.getSelectionBox().prop('checked', that.$box.prop('checked')).trigger('change');
			});

			// [событие] клик по чекбоксу
			that.$el.on('change', 'td ' + that.options.checkboxes, function () {
				var $box = $(this);
				var $row = $box.closest('tr');

				$box.prop('checked') ? $row.addClass('selected') : $row.removeClass('selected');
				that.refresh();
			});
		};


		this.setup();
	};
})(window.jQuery);