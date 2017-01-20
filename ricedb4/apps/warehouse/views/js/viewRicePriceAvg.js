$(function () {
    var getUrl = window.location;
    $("#date1, #date2").datepicker({
        format: 'yyyy-mm-dd',
        //daysOfWeekDisabled: [0, 6],
        autoClose: true
    });

    $("#date1, #date2").datepicker('setDate', new Date());

    $("#date1").on("changeDate", function () {
        $('#date1').datepicker('hide');
        $('#date2').datepicker('setStartDate', new Date($(this).val()));
        showRicePriceAvg();
    });

    $("#date2").on("changeDate", function () {
        $('#date2').datepicker('hide');
        $('#date1').datepicker('setEndDate', new Date($(this).val()));
        showRicePriceAvg();
    });

    showRicePriceAvg();

    $("#btnPDF").click(function () {
        window.open("http://" + getUrl.host.split("/")[0] + "/reporter/api/rice/report/priceAvg?startDate=" + $("#date1").val() + "&endDate=" + $("#date2").val() + "&export=view");
    })
    $("#btnWORD").click(function () {
        window.open("http://" + getUrl.host.split("/")[0] + "/reporter/api/rice/report/priceAvg?startDate=" + $("#date1").val() + "&endDate=" + $("#date2").val() + "&export=word");
    })
    $("#btnEXCEL").click(function () {
        window.open("http://" + getUrl.host.split("/")[0] + "/reporter/api/rice/report/priceAvg?startDate=" + $("#date1").val() + "&endDate=" + $("#date2").val() + "&export=excel");
    })
});

function showRicePriceAvg() {
    $("#dataBody").html('<tr><td colspan="11" class="text-center">Loading...</td></tr>');

    setTimeout(function () {
        var dataSet = [];

        var datas = callAjax(js_context_path + "/api/warehouse/viewRicePriceAvg/view", "post", {date1: $("#date1").val(), date2: $("#date2").val()}, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            $.each(datas["lists"], function (key, value) {
                dataSet.push(value);
            });
        }

        var t = $("#table").DataTable({
            "data": dataSet,
            "order": [[0, 'asc']],
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "data": "riceTypeId",
                    "sClass": "text-center col-md-1"
                },
                {
                    "targets": 1,
                    "data": "riceType",
                    "sClass": "text-left col-md-3"
                },
                {
                    "targets": 2,
                    "data": "sumOldMean1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 3,
                    "data": "sumOldMean2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 4,
                    "data": "OldPrice",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 5,
                    "data": "sumOldNewMean1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 6,
                    "data": "sumOldNewMean2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 7,
                    "data": "OldNewPrice",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 8,
                    "data": "sumNewMean1",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 9,
                    "data": "sumNewMean2",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                },
                {
                    "targets": 10,
                    "data": "NewPrice",
                    "sClass": "text-right col-md-1",
                    "render": function (data) {
                        if (data == 0)
                            return "-";
                        else
                            return accounting.formatNumber(data, 0, ",", ".");
                    }
                }
            ]
        });

        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }, 100);
}