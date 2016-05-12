var Index = function () {

	return {

        getTypeaheadOpts: function(cities) {
            return {
                source: cities,
                displayText: function(item) {
                    return item.name + ' (' + item.country + ')';
                },
                matcher: function (item) {
                    var it = item.name;
                    return ~it.toLowerCase().indexOf(this.query.toLowerCase());
                },
                highlighter: function (item) {
                    var it = item.split('(');
                    var html = $('<div></div>');
                    var query = this.query;
                    var i = it[0].toLowerCase().indexOf(query.toLowerCase());
                    var len, leftPart, middlePart, rightPart, strong;
                    len = query.length;
                    if(len === 0){
                        return html.text(item).html();
                    }
                    while (i > -1) {
                        leftPart = it[0].substr(0, i);
                        middlePart = it[0].substr(i, len);
                        rightPart = it[0].substr(i + len);
                        strong = $('<strong></strong>').text(middlePart);
                        html
                            .append(document.createTextNode(leftPart))
                            .append(strong);
                        it[0] = rightPart;
                        i = it[0].toLowerCase().indexOf(query.toLowerCase());
                    }
                    return html.append(document.createTextNode(it[0] + ' (' + it[1])).html();
                }
            };
        },

		initForm: function (i, locale, itemTitle) {
			// Автодополнение полей
			var cities;
			$.get(locale + '/cities.json', function(data){
				cities = data;
                $( ".target-typeahead" ).typeahead(Index.getTypeaheadOpts(cities));
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

                $( ".target-typeahead" ).typeahead(Index.getTypeaheadOpts(cities));

				i++;
			});

			// Обработчик нажатия кнопки удаления поля "Пункт n"
			$('body').on('click', 'button.remove-target', function() {
				$section = $(this).parents('section');
				$section.hide('slow', function() {
					$section.remove();
				});
			});
		}

	};
}();