$(function(){
    $(".owl-carousel table.table").each(function(){
        var id = $(this).attr("id");

        viewInventory(id)
    });

    ricePrice();

    initCarousel();

    auctionLatest();

    viewReserve();
});

function viewInventory(option){
    var dataSet = [];
    var total = 0;

    var dataX = [];
    var dataY = [];
    $("#"+option+" tbody").html('<tr><td colspan="2" class="text-center">Loading...</td></tr>');

    setTimeout(function(){
        var datas = callAjax(js_context_path+"/api/home/widget/"+option+"Group", "post", {}, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            $.each(datas["lists"], function(key, value){
                dataSet.push(value);

                total += parseFloat(value["weight"]);

                dataX.push(value[option]);
                dataY.push(parseFloat(value["weight"]));
            });
        }

        var t = $("#"+option).DataTable( {
            "destroy": true,
            "data": dataSet,
            "order": [[ 1, 'desc' ]],
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
                    "render": function(data){
                        var content = accounting.formatNumber(data, 6, ",", ".");

                        return content;
                    }
                },
                {
                    "targets": 2,
                    "data": "weight",
                    "sClass": "text-center col-md-2",
                    "render": function(data){
                        var percent = parseFloat((data / total) * 100).toFixed(2);
                        var content = percent+'%';

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

function initCarousel(){
    var owl = $("#owl");
    owl.owlCarousel({
        items: 1,
        //autoplay: 5000,
        slideSpeed: 1500,
        autoHeight: true,
        navigation:true
    });

    $(".next").click(function(){
        owl.trigger('next.owl.carousel');
    });
    $(".prev").click(function(){
        owl.trigger('prev.owl.carousel');
    });


    var owl2 = $("#price");
    owl2.owlCarousel({
        items: 1,
        loop: true,
        autoplay: 7000,
        slideSpeed: 2000,
        autoHeight: true,
        navigation:true
    });
}

function drawGraph(option, dataX, dataY){
    var div = option+'Chart';

    var title;
    if(option == "type") title =  "ปริมาณแยกตามชนิดข้าว";
    else if(option == "project") title =  "ปริมาณแยกตามปีโครงการ";
    else if(option == "grade") title =  "ปริมาณแยกตามเกรด";

    var chart = new Highcharts.Chart({
        chart: {
            renderTo: div,
            type: 'line',
            events: {
                load: function(){
                    setTimeout(function() {
                        chart.setSize($("#"+div).width(), $("#"+div).height());
                    }, 1);
                }
            }
        },
        title: {
            text: title
        },
        tooltip: {
            formatter: function() {
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

function ricePrice(){
    var price = '';
    var datas = callAjax(js_context_path+"/api/home/widget/ricePrice", "post", {}, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        $.each(datas["lists"], function(key, value){
            price += '<div>'
                    + '<h4 class="text-dark">'+value["Type"]+'</h4>'
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
                                + '<td class="text-right">'+checkZero(value["OldPriceMin1"])+'</td>'
                                + '<td class="text-right">'+checkZero(value["OldPriceMax1"])+'</td>'
                            + '</tr>'
                            + '<tr>'
                                + '<td class="text-center">ใหม่</td>'
                                + '<td class="text-right">'+checkZero(value["NewPriceMin1"])+'</td>'
                                + '<td class="text-right">'+checkZero(value["NewPriceMax1"])+'</td>'
                            + '</tr>'
                            + '<tr>'
                                + '<td rowspan="2">สมาคมโรงสี</td>'
                                + '<td class="text-center">เก่า</td>'
                                + '<td class="text-right">'+checkZero(value["OldPriceMin2"])+'</td>'
                                + '<td class="text-right">'+checkZero(value["OldPriceMax2"])+'</td>'
                            + '</tr>'
                            + '<tr>'
                                + '<td class="text-center">ใหม่</td>'
                                + '<td class="text-right">'+checkZero(value["NewPriceMin2"])+'</td>'
                                + '<td class="text-right">'+checkZero(value["NewPriceMax2"])+'</td>'
                            + '</tr>'
                        + '</tbody>'
                    + '</table>'
                + '</div>';
        });

    }

    $("#price").html(price);
}

function checkZero(input){
    var output = input
    if(input == 0.0){
        output = '-';
    }

    return output;
}

function auctionLatest(){
    var auction = '';
    var datas = callAjax(js_context_path+"/api/home/widget/auctionLatest", "post", {}, "json");
    if (typeof datas !== "undefined" && datas !== null) {

    }

    $("#auction").html(auction);
}

function viewReserve(){
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

    var datas = callAjax(js_context_path+"/api/home/widget/viewReserve", "post", {}, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        var count = 0;
        $.each(datas["lists"], function(key, val){
            reserve += '<tr>'
                    + '<td class="text-center">'+(++count)+'</td>'
                    + '<td class="text-left">'+val["reserveName"]+' - '+val["detail"]+'</td>'
                    + '<td class="text-right">'+val["target"]+'</td>'
                + '</tr>';
        });
    }

                reserve += '</tbody>'
            + '</table>'
        + '</div>';

    $("#reserve").html(reserve);
}