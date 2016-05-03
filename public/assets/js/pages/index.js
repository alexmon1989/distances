var Index = function () {

	return {

		initForm: function (i, locale, itemTitle) {
			// Автодополнение полей
			var cities;
			$.get(locale + '/cities.json', function(data){
				cities = data;
				$( ".target-typeahead" ).typeahead({ source:cities });
			},'json');

			// Обработчик нажатия ссылки "добавить пункт"
			$( "#add-target" ).click(function(e) {
				e.preventDefault();

				var sectionHTML =
					'<section>' +
					'<label class="label">' + itemTitle + ' ' + i + '</label>' +
					'<label class="input">' +
					'<div class="input-group">' +
					'<input type="text" name="targets[' + (i - 1) + ']" id="target_' + i + '" class="form-control target-typeahead" placeholder="' + itemTitle + ' ' + i + '">' +
					'<span class="input-group-btn">' +
					'<button type="button" class="btn btn-danger remove-target"><i class="fa fa-times" aria-hidden="true"></i></button>' +
					'</span>' +
					'</div>' +
					'</label>' +
					'</section>';

				$( '.added-targets' ).append(sectionHTML);

				$( ".target-typeahead" ).typeahead({ source:cities });

				i++;
			});

			// Обработчик нажатия кнопки удаления поля "Пункт n"
			$('body').on('click', 'button.remove-target', function() {
				$section = $(this).parents('section');
				$section.hide('slow', function() {
					$section.remove();
				});
			});
		},

	};
}();