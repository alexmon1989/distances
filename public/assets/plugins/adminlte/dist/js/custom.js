$(document).ready(function() {

    // Все таблицы с данными, будт иметь id=data. Превращаем их в "умные" dataTables (для сортировок, фильтраций, постранич. навигации)
    $('#data').dataTable({
        "stateSave": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Russian.json"
        }
    });

    // Подтверждение удаления
    $('body').on('click', '.item-delete', function() {
        return confirm('Вы уверены?');
    });

    // Очистка дублей
    $("#clear-doubles").click(function() {
        $("#clear-doubles").attr('disabled', true);
        $("#success-block").hide();
        $("#error-block").hide();
        $("#loading-spinner").show();

        $.post('/admin/service/clear-doubles').done(function(data) {
            $("#clear-doubles-date").html(data.date);
            $("#success-block").html('Количество удалённых дублей: <strong>' + data.deleted + '</deleted>').show();
        }).fail(function() {
            $("#error-block").html('Произошла ошибка!').show();
        }).always(function() {
            $("#clear-doubles").attr('disabled', false);
            $("#loading-spinner").hide();
        });
    });
});