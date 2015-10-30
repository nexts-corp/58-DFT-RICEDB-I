$(function () {
    $("#date").datepicker({
        format: 'yyyy-mm-dd',
        //daysOfWeekDisabled: [0, 6],
        autoClose: true
    });

    $("#date").datepicker('setDate', new Date());

    $("#date").on("changeDate", function () {
        $('#date').datepicker('hide');
        showRicePrice();
    });

    showRicePrice();
});

function showRicePrice(){
    $("#dataBody").html('<tr><td colspan="10" class="text-center">Loading...</td></tr>');

    setTimeout(function(){
        var dataSet = [];

        var datas = callAjax(js_context_path+"/api/warehouse/viewRicePrice/view", "post", {date: $("#date").val()}, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            $.each(datas["lists"], function(key, value){
                dataSet.push(value);
            });
        }

        var t = $("#table").DataTable( {
            "data": dataSet,
            "order": [[ 0, 'asc' ]],
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "data": "id",
                    "sClass": "text-center col-md-1"
                },
                {
                    "targets": 1,
                    "data": "type",
                    "sClass": "text-left col-md-3"
                },
                {
                    "targets": 2,
                    "data": "oldPriceMin1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 3,
                    "data": "oldPriceMax1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 4,
                    "data": "newPriceMin1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 5,
                    "data": "newPriceMax1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 6,
                    "data": "oldPriceMin2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 7,
                    "data": "oldPriceMax2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 8,
                    "data": "newPriceMin2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 9,
                    "data": "newPriceMax2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if(data == 0) return "-";
                        else return accounting.formatNumber(data, 0, ",", ".");
                    }
                }
            ]
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }, 100);
}