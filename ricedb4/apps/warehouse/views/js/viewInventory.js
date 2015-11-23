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

    $('a[href="#search"]').click(function(){
        $("#search select").each(function(){
            var id = $(this).attr("id");
            var call = $(this).attr("data-call");

            var result = listsObject(call);
            $("#"+id).html(result).select2();
        });

        allInventory();
    });
});

function groupBy(option){
    var dataSet = [];

    var totalWeight = 0;
    var totalPercent = 0;

    $("#"+option+" table tbody").html('<tr><td colspan="3" class="text-center">Loading...</td></tr>');
    $("#"+option+" table tfoot").find("td").eq(1).html("-");
    $("#"+option+" table tfoot").find("td").eq(2).html("-");

    setTimeout(function(){
        var datas = callAjax(js_context_path+"/api/warehouse/viewInventory/"+option, "post", {}, "json");

        if (typeof datas !== "undefined" && datas !== null) {
            $.each(datas["lists"], function(key, value){
                dataSet.push(value);

                totalWeight += parseFloat(value["weight"]);
            });

            $("#"+option+" table tfoot").find("td").eq(1).html(accounting.formatNumber(totalWeight, 6, ",", "."));
            $("#"+option+" table tfoot").find("td").eq(2).html(accounting.formatNumber(100, 2, ",", ".")+"%");
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
                        var percent = parseFloat((data / totalWeight) * 100).toFixed(2);
                        var content = percent+'%';

                        return content;
                    }
                }
            ]
        });
    }, 100);
}

function allInventory(){
    var t = $('#table').DataTable( {
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: js_context_path+"/api/warehouse/viewInventory/all",
            type: "post"
        },
        "columnDefs": [
            {
                "targets": 0,
                "searchable": false,
                "orderable": false,
                "data": "id",
                "sClass": "text-center"
            },
            {
                "targets": 1,
                "data": "provinceNameTH",
                "sClass": "text-center"
            },
            {
                "targets": 2,
                "data": "code",
                "sClass": "text-center"
            },
            {
                "targets": 3,
                "data": "silo",
                "sClass": "text-left"
            },
            {
                "targets": 4,
                "data": "associate",
                "sClass": "text-center"
            },
            {
                "targets": 5,
                "data": "warehouse",
                "sClass": "text-center"
            },
            {
                "targets": 6,
                "data": "stack",
                "sClass": "text-center"
            },
            {
                "targets": 7,
                "data": "project",
                "sClass": "text-center"
            },
            {
                "targets": 8,
                "data": "type",
                "sClass": "text-center"
            },
            {
                "targets": 9,
                "data": "grade",
                "sClass": "text-center"
            },
            {
                "targets": 10,
                "data": "tWeight",
                "sClass": "text-center",
                "render": function(data){
                    var content = accounting.formatNumber(data, 2, ",", ".");

                    return content;
                }
            }
        ],
        "rowCallback": function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = (page * length + (iDisplayIndex +1));
            $('td', row).eq(0).html(index);
        }
    });

    $("#sProvince").change(function() {
        t.columns(1).search(this.value).draw();
    });

    $("#sCode").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(2).search(this.value).draw();
        }
    });

    $("#sSilo").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(3).search(this.value).draw();
        }
    });

    $("#sWarehouse").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(5).search(this.value).draw();
        }
    });

    $("#sStack").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(6).search(this.value).draw();
        }
    });

    $('#sProject').change(function() {
        t.columns(7).search(this.value).draw();
    });

    $('#sType').change(function() {
        t.columns(8).search(this.value).draw();
    });

    $('#sGrade').change(function() {
        t.columns(9).search(this.value).draw();
    });

}

function listsObject(dataCall){
    var html = '<option value="" selected="selected">ทั้งหมด</option>';

    var datas = callAjax(js_context_path+"/api/reserve/manage/"+dataCall, "post", {}, "json");
    if(typeof datas !== "undefined" && datas !== null){
        $.each(datas["lists"], function(key, value){
            html += '<option value="'+value["id"]+'">'+value["name"]+'</option>';
        });
    }

    return html;
}