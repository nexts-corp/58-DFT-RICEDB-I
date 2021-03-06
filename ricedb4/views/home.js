$(function () {
    $(".owl-carousel table.table").each(function () {
        var id = $(this).attr("id");

        viewInventory(id)
    });

    ricePrice();

    initCarousel();

    auctionLatest();

    viewReserve();

    tracking();

});

function viewInventory(option) {
    var dataSet = [];
    var total = 0;

    var dataX = [];
    var dataY = [];
    $("#" + option + " tbody").html('<tr><td colspan="3" class="text-center">Loading...</td></tr>');

    setTimeout(function () {
        var datas = callAjax(js_context_path + "/api/home/widget/" + option + "Group", "post", {}, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            $.each(datas["lists"], function (key, value) {
                dataSet.push(value);

                total += parseFloat(value["weight"]);

                dataX.push(value[option]);
                dataY.push(parseFloat(value["weight"]));
            });
            $("#" + option + " tfoot").find("td").eq(1).html(accounting.formatNumber(total, "6", ",", "."));
            $("#" + option + " tfoot").find("td").eq(2).html(accounting.formatNumber(100, "2", ",", ".") + "%");
        }

        var t = $("#" + option).DataTable({
            "destroy": true,
            "data": dataSet,
            "order": [[1, 'desc']],
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "data": option,
                    "sClass": "text-center col-md-5"
                },
                {
                    "targets": 1,
                    "data": "weight",
                    "sClass": "text-right col-md-5",
                    "render": function (data) {
                        var content = accounting.formatNumber(data, 6, ",", ".");

                        return content;
                    }
                },
                {
                    "targets": 2,
                    "data": "weight",
                    "sClass": "text-center col-md-2",
                    "render": function (data) {
                        var percent = parseFloat((data / total) * 100).toFixed(2);
                        var content = percent + '%';

                        return content;
                    }
                }
            ],
            "paging": false,
            "bFilter": false
        });

        drawGraph(option, dataX, dataY);

    }, 100);


}

function initCarousel() {
    var owl = $("#owl");
    owl.owlCarousel({
        items: 1,
        //autoplay: 5000,
        slideSpeed: 1500,
        autoHeight: true,
        navigation: true
    });

    $(".next").click(function () {
        owl.trigger('next.owl.carousel');
    });
    $(".prev").click(function () {
        owl.trigger('prev.owl.carousel');
    });


    var owl2 = $("#price");
    owl2.owlCarousel({
        items: 1,
        loop: true,
        autoplay: 7000,
        slideSpeed: 2000,
        autoHeight: true,
        navigation: true
    });
}

function drawGraph(option, dataX, dataY) {
    var div = option + 'Chart';

    var title;
    if (option == "type")
        title = "ปริมาณแยกตามชนิดข้าว";
    else if (option == "project")
        title = "ปริมาณแยกตามปีโครงการ";
    else if (option == "grade")
        title = "ปริมาณแยกตามเกรด";

    var chart = new Highcharts.Chart({
        chart: {
            renderTo: div,
            type: 'line',
            events: {
                load: function () {
                    setTimeout(function () {
                        chart.setSize($("#" + div).width(), $("#" + div).height());
                    }, 1);
                }
            }
        },
        title: {
            text: title
        },
        tooltip: {
            formatter: function () {
                return this.x + " : " + accounting.formatNumber(this.y, 2, ",", ".") + " ตัน";
            }
        },
        xAxis: {
            categories: dataX
        },
        yAxis: {
            title: {
                text: 'ปริมาณน้ำหนัก (ตัน)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: false
                },
                enableMouseTracking: true
            }
        },
        credits: {
            enabled: false
        },
        series: [{
                name: title,
                data: dataY
            }]
    });
}

function ricePrice() {
    var price = '';
    callbackAjax(js_context_path + "/api/home/widget/ricePrice", "post", {}, "json",
            function (datas) {
                if (typeof datas !== "undefined" && datas !== null) {
                    $.each(datas["lists"], function (key, value) {
                        price += '<div>'
                                + '<h4 class="text-dark">' + value["Type"] + '</h4>'
                                + '<table class="table">'
                                + '<thead>'
                                + '<tr>'
                                + '<th class="text-center">ราคา (บาท/ตัน)</th>'
                                + '<th class="text-center">ชนิดข้าว</th>'
                                + '<th class="text-right">ต่ำสุด</th>'
                                + '<th class="text-right">สูงสุด</th>'
                                + '</tr>'
                                + '</thead>'
                                + '<tbody>'
                                + '<tr>'
                                + '<td rowspan="2">กรมการค้าภายใน</td>'
                                + '<td class="text-center">เก่า</td>'
                                + '<td class="text-right">' + checkZero(value["OldPriceMin1"]) + '</td>'
                                + '<td class="text-right">' + checkZero(value["OldPriceMax1"]) + '</td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td class="text-center">ใหม่</td>'
                                + '<td class="text-right">' + checkZero(value["NewPriceMin1"]) + '</td>'
                                + '<td class="text-right">' + checkZero(value["NewPriceMax1"]) + '</td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td rowspan="2">สมาคมโรงสี</td>'
                                + '<td class="text-center">เก่า</td>'
                                + '<td class="text-right">' + checkZero(value["OldPriceMin2"]) + '</td>'
                                + '<td class="text-right">' + checkZero(value["OldPriceMax2"]) + '</td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td class="text-center">ใหม่</td>'
                                + '<td class="text-right">' + checkZero(value["NewPriceMin2"]) + '</td>'
                                + '<td class="text-right">' + checkZero(value["NewPriceMax2"]) + '</td>'
                                + '</tr>'
                                + '</tbody>'
                                + '</table>'
                                + '<div class="text-right text-sm">ข้อมูล ณ วันที่ ' + thaiDate(value["Date"].substr(8, 2), value["Date"].substr(5, 2), value["Date"].substr(0, 4)) + '</div>'
                                + '</div>';
                    });

                }

                $("#price").html(price);
            });

}

function checkZero(input) {
    var output = '';
    if (input == 0.0) {
        output = '-';
    } else {
        output = accounting.formatNumber(input, 2, ",", ".");
    }

    return output;
}

function auctionLatest() {
    callbackAjax(js_context_path + "/api/home/widget/auctionLatest", "post", {}, "json",
            function (datas) {
                if (typeof datas !== "undefined" && datas !== null) {
                    var data = datas["lists"];

                    //console.log(data["status"]);
                    if (typeof data["status"] !== "undefined") {
                        var index = data["status"].indexOf('(');
                        var auction = '<div>'
                                + '<div class="row text-center">'
                                + '<h4 class="text-dark">'
                                + 'ประมูลครั้งที่ ' + data["status"].substring(0, index)
                                + '<br> ' + data["status"].substring(index, data["status"].length)
                                + '<div class="text-sm">วันที่ ' + data["auctionDate"] + '</div>'
                                + '</h4>'
                                + '</div>'
                                + '<div class="row">'
                                + '<div class="col-md-3 text-right text-bold">ปริมาณ :</div>'
                                + '<div class="col-md-9 text-left">' + accounting.formatNumber(data["sumWeight"], 6, ",", ".") + ' ตัน</div>'
                                + '</div>'
                                + '<div class="row">'
                                + '<div class="col-md-3 text-right text-bold">มูลค่า :</div>'
                                + '<div class="col-md-9 text-left">' + accounting.formatNumber(data["sumPrice"], 2, ",", ".") + ' บาท</div>'
                                + '</div>'
                                + '<table class="table">'
                                + '<thead>'
                                + '<tr>'
                                + '<th class="text-center">ลำดับ</th>'
                                + '<th class="text-center">ชนิด</th>'
                                + '<th class="text-right">ปริมาณ (ตัน)</th>'
                                + '</tr>'
                                + '</thead>'
                                + '<tbody>';

                        var count = 0;
                        $.each(data["riceGroup"], function (key, val) {
                            auction += '<tr>'
                                    + '<td class="text-center">' + (++count) + '</td>'
                                    + '<td class="text-left">' + val["typeName"] + '</td>'
                                    + '<td class="text-right">' + accounting.formatNumber(val["weight"], 6, ",", ".") + '</td>'
                                    + '</tr>';
                        });

                        auction += '</tbody>'
                                + '</table>'
                                + '</div>';

                    }
                }

                $("#auction").html(auction);
            });

}

function viewReserve() {
    callbackAjax(js_context_path + "/api/home/widget/viewReserve", "post", {}, "json", function (datas) {
        if (typeof datas !== "undefined" && datas !== null) {
            var reserve = '<div>'
                    + '<table class="table">'
                    + '<thead>'
                    + '<tr>'
                    + '<th class="text-center">ลำดับ</th>'
                    + '<th class="text-center">รายละเอียด</th>'
                    + '<th class="text-right">ปริมาณ (ตัน)</th>'
                    + '</tr>'
                    + '</thead>'
                    + '<tbody>';

            var count = 0;
            $.each(datas["lists"], function (key, val) {
                reserve += '<tr>'
                        + '<td class="text-center col-md-1">' + (++count) + '</td>'
                        + '<td class="text-left col-md-7">' + val["reserveName"] + ' - ' + val["detail"] + '</td>'
                        + '<td class="text-right col-md-4">' + accounting.formatNumber(val["target"], 2, ",", ".") + '</td>'
                        + '</tr>';
            });

            reserve += '</tbody>'
                    + '</table>'
                    + '</div>';

            $("#reserve").html(reserve);
        }

    });


}

function tracking() {

    callbackAjax(js_context_path + "/api/home/widget/tracking", "post", {}, "json",
            function (datas) {
                if (typeof datas !== "undefined" && datas !== null) {
                    var data = datas["lists"];

                    //console.log(data["status"]);
                    if (typeof data !== "no data") {
                        var index = data["status"].indexOf('(');
                        var auction = '<div>'
                                + '<div class="row text-center">'
                                + '<h4 class="text-dark">'
                                + 'ประมูลครั้งที่ ' + data["status"].substring(0, index)
                                + '<br> ' + data["status"].substring(index, data["status"].length)
                                + '<div class="text-sm">วันที่ ' + data["auctionDate"] + '</div>'
                                + '<div class="text-danger">ผ่านมาแล้ว ' + data["daysPass"] + ' วัน!</div>'
                                + '</h4>'
                                + '</div>'
                                + '<div class="row">'
                                + '<div class="col-md-3 text-right text-bold">ทำสัญญา :</div>'
                                + '<div class="col-md-9 text-left">' + accounting.formatNumber(data["weightApprove"], 6, ",", ".") + ' ตัน</div>'
                                + '</div>'
                                + '<div class="row">'
                                + '<div class="col-md-3 text-right text-bold">ส่งมอบ :</div>'
                                + '<div class="col-md-9 text-left">' + accounting.formatNumber(data["weightReceived"], 2, ",", ".") + ' ตัน</div>'
                                + '</div>'
                                + '<table class="table">'
                                + '<thead>'
                                + '<tr>'
                                + '<th class="text-center">ลำดับ</th>'
                                + '<th class="text-center">ผู้เข้าร่วม</th>'
                                + '<th class="text-right">ปริมาณ (ตัน)</th>'
                                + '</tr>'
                                + '</thead>'
                                + '<tbody>';

                        var count = 0;
                        $.each(data["tracking"], function (key, val) {
                            auction += '<tr>'
                                    + '<td class="text-center">' + (++count) + '</td>'
                                    + '<td class="text-left">' + val["associate"] + '</td>'
                                    + '<td class="text-right">' + accounting.formatNumber(val["weightApprove"], 6, ",", ".") + '</td>'
                                    + '</tr>';
                        });

                        auction += '</tbody>'
                                + '</table>'
                                + '</div>';

                    }
                }
                $("#tracking").html(auction);
            });
}