$(document).ready(function () {
    function update(id) {
        var data = JSON.stringify($('#collection-edit-form').serializeArray()); //  <-----------
        console.log(data);
        return $.ajax({
            type: "PUT",
            url: "/collection/" + id,
            contentType: "application/json",
            dataType: 'json',
            data: data
        });
    }

    $('#collection-edit-form').on('submit', function (e) {
        e.preventDefault();
        console.log($("input:hidden[name='id']").val());
        update(($("input:hidden[name='id']").val())).done(function (result) {
            if (result && result.data) {
                alert('Данные обновлены');
            }
            else alert('Данные не обновлены' + result.data);
        });
    });
});
