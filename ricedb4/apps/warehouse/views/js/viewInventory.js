$(function () {
    $('a[href="#project"]').click(function(){
        groupBy("project");
    }).trigger("click");

    $('a[href="#province"]').click(function(){
        groupBy("province");
    });

    $('a[href="#type"]').click(function(){
        groupBy("type");
    });

    $('a[href="#grade"]').click(function(){
        groupBy("grade");
    });

    $('a[href="#silo"]').click(function(){
        groupBy("silo");
    });
});

function groupBy(option){
    var dataSet = [];

    $("#"+option+" table tbody").html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
    $("#"+option+" table tfoot").find("td").eq(1).html("-");
    $("#"+option+" table tfoot").find("td").eq(2).html("-");
    $("#"+option+" table tfoot").find("td").eq(3).html("-");

    setTimeout(function(){
        var datas = callAjax(js_context_path+"/api/warehouse/viewInventory/"+option, "post", {}, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            var totalWeight = 0;
            $.each(datas["lists"], function(key, value){
                dataSet.push(value);

                totalWeight += parseFloat(value["weight"]);
            });

            $("#"+option+" table tfoot").find("td").eq(1).html(accounting.formatNumber(totalWeight, 6, ",", "."));
            $("#"+option+" table tfoot").find("td").eq(2).html(accounting.formatNumber(totalWeight, 2, ",", "."));
            $("#"+option+" table tfoot").find("td").eq(3).html(accounting.formatNumber(totalWeight, 2, ",", "."));
        }

        var t = $("#"+option+" table").DataTable( {
            "destroy": true,
            "data": dataSet,
            "order": [[ 1, 'desc' ]],
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "data": option,
                    "sClass": "text-left"
                },
                {
                    "targets": 1,
                    "data": "weight",
                    "sClass": "text-right",
                    "render": function(data){
                        var content = accounting.formatNumber(data, 6, ",", ".");

                        return content;
                    }
                },
                {
                    "targets": 2,
                    "data": "weight",
                    "sClass": "text-right",
                    "render": function(data){
                        var content = accounting.formatNumber(data, 2, ",", ".");

                        return content;
                    }
                },
                {
                    "targets": 3,
                    "data": "weight",
                    "sClass": "text-right",
                    "render": function(data){
                        var content = accounting.formatNumber(data, 2, ",", ".");

                        return content;
                    }
                }
            ]
        });
    }, 100);
}