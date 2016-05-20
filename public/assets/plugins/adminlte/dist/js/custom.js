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
} );