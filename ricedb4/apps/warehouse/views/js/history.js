$(document).ready(function () {
    $("#btnFind").click(function () {
        $("#divLists").show();
        $("#divHistory").hide();
        var warehouse = $("#findName").val();
        var data = callAjax(js_context_path + "/api/warehouse/history/find", "post", {warehouse: warehouse}, "json")["warehouse"];

        var t = $("#tbLists").DataTable({
            "destroy": true,
            "data": data,
            "order": [[1, 'asc']],
            "iDisplayLength": 50,
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "data": "wareHouseCode",
                    "sClass": "text-center"
                },
                {
                    "targets": 1,
                    "data": "province",
                    "sClass": "text-center"
                },
                {
                    "targets": 2,
                    "data": "associate",
                    "sClass": "text-center"
                },
                {
                    "targets": 3,
                    "data": "wareHouseCode",
                    "sClass": "text-center"
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "data": "wareHouseCode",
                    "sClass": "text-center",
                    "render": function (data) {
                        var content = '<button class="btn btn-primary btnSearch" data-whCode="' + data + '" title="รายละเอียด"><i class="fa fa-list"></i></button>';
                        return content;
                    }
                }
            ]
        });

        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        $(".btnSearch").unbind().click(function () {
            $("#divLists").hide();
            $("#divHistory").show();
            var whCode = $(this).attr("data-whCode");
            $("#curWareHouse").text(whCode);
            var history = callAjax(js_context_path + "/api/warehouse/history/get", "post", {warehouse: whCode}, "json")["auction"];
            var h = $("#tbHistory").DataTable({
                "destroy": true,
                "data": history,
                "order": [[1, 'asc']],
                "iDisplayLength": 50,
                "columnDefs": [
                    {
                        "targets": 0,
                        "searchable": false,
                        "orderable": false,
                        "data": "auctionNo",
                        "sClass": "text-center"
                    },
                    {
                        "targets": 1,
                        "data": "auctionCode",
                        "sClass": "text-center col-md-2"
                    },
                    {
                        "targets": 2,
                        "data": "weightAll",
                        "sClass": "text-center",
                        "render": function (data) {
                            return accounting.formatNumber(parseFloat(data), 6, ",", ".");
                        }
                    },
                    {
                        "targets": 3,
                        "data": "bidderName",
                        "sClass": "text-center"
                    },
                    {
                        "targets": 4,
                        "data": "bidderPrice",
                        "sClass": "text-center",
                        "render": function (data) {
                            return accounting.formatNumber(data, 2, ",", ".");
                        }
                    },
                    {
                        "targets": 5,
                        "data": "FV",
                        "sClass": "text-center",
                        "render": function (data) {
                            return accounting.formatNumber(data, 2, ",", ".");
                        }
                    },
                    {
                        "targets": 6,
                        "data": "isSale",
                        "sClass": "text-center",
                        "render": function (data, type, row) {
                            var txt = '';
                            if (data == 'Y') {
                                txt = 'ขายแล้ว';
                            } else if (data == 'R') {
                                txt = 'สงวนสิทธิ์';
                            } else if (data == 'C') {
                                txt = 'ติดเงื่อนไข';
                            } else {
                                txt = 'ไม่ขาย';
                            }
                            if (row['bidderName'] == null) {
                                txt = 'ไม่ถูกเสนอซื้อ';
                            }
                            return txt;
                        }
                    }

                ]
            });

            h.on('order.dt search.dt', function () {
                h.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();


        });


    });
    $("#btnBack").click(function () {
        $("#divLists").show();
        $("#divHistory").hide();
    });
    $(".btn-excel").unbind().click(function () {
        window.open(js_context_path + "/api/warehouse/history/export/" + $("#curWareHouse").text());
    });

});

