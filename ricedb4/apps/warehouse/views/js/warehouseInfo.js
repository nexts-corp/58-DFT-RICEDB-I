var idArr = [];
var fdata = {};

$(function(){
    $(".row select").each(function(){
        var id = $(this).attr("id");
        var call = $(this).attr("data-call");

        var result = listsObject(call);
        $("#"+id).html(result).select2();

        idArr.push("#"+id);
        fdata[id] = $(this).val();
    });

    $(idArr.join(",")).change(function(){
        var id = $(this).attr("id");
        fdata[id] = $(this).val();
    });

    listsAllRice();

});

function listsAllRice(){
    var t = $('#table').DataTable( {
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: js_context_path+"/api/warehouse/warehouseInfo/listsAllRice",
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
                "data": "zoneNameTH",
                "sClass": "text-center"
            },
            {
                "targets": 2,
                "data": "provinceNameTH",
                "sClass": "text-center"
            },
            {
                "targets": 3,
                "data": "code",
                "sClass": "text-center"
            },
            {
                "targets": 4,
                "data": "silo",
                "sClass": "text-left"
            },
            {
                "targets": 5,
                "data": "associate",
                "sClass": "text-center"
            },
            {
                "targets": 6,
                "data": "warehouse",
                "sClass": "text-center"
            },
            {
                "targets": 7,
                "data": "stack",
                "sClass": "text-center"
            },
            {
                "targets": 8,
                "data": "project",
                "sClass": "text-center"
            },
            {
                "targets": 9,
                "data": "type",
                "sClass": "text-center"
            },
            {
                "targets": 10,
                "data": "grade",
                "sClass": "text-center"
            },
            {
                "targets": 11,
                "data": "discountRate",
                "sClass": "text-center"
            },
            {
                "targets": 12,
                "data": "status",
                "sClass": "text-center"
            },
            {
                "targets": 13,
                "data": "id",
                "sClass": "text-center",
                "render": function (data) {
                    var content = '<button class="btn btn-primary history" data-id="'+data+'" title="ดูประวัติ"><i class="fa fa-list"></i></button>&nbsp;';

                    return content;
                }
            }
        ]
    });
    /*t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } );*/


    $("#zone").change(function() {
        t.columns(1).search(this.value).draw();
    });

    $("#province").change(function() {
        t.columns(2).search(this.value).draw();
    });

    $("#code").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(3).search(this.value).draw();
        }
    });

    $("#silo").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(4).search(this.value).draw();
        }
    });

    $('#project').change(function() {
        t.columns(8).search(this.value).draw();
    });

    $('#type').change(function() {
        t.columns(9).search(this.value).draw();
    });

    $('#grade').change(function() {
        t.columns(10).search(this.value).draw();
    });

    $('#status').change(function() {
        t.columns(12).search(this.value).draw();
    } );

    $("#table").off("click", "button.history").on("click", "button.history", function(){
        $("#viewHistory").modal("show");

        var id = $(this).attr("data-id");
        riceInfo(id);
    });
}

function listsObject(dataCall){
    var html = '<option value="" selected="selected">ทั้งหมด</option>';

    var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/"+dataCall, "post", {}, "json");
    if(typeof datas !== "undefined" && datas !== null){
        $.each(datas["lists"], function(key, value){
            html += '<option value="'+value["id"]+'">'+value["name"]+'</option>';
        });
    }

    return html;
}

function riceInfo(id){
    var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/riceInfo", "post", {id: id}, "json");
    if(typeof datas !== "undefined" && datas !== null){
        var value = datas["lists"];

        $("#codeDisp").html(value["code"]);
        $("#siloDisp").html(value["silo"]+' ['+value["provinceNameTH"]+'] ['+value["associate"]+']');
        $("#warehouseDisp").html(value["warehouse"]);
        $("#stackDisp").html(value["stack"]);
        $("#projectDisp").html(value["project"]);
        $("#typeDisp").html(value["type"]);
        $("#gradeDisp").html(value["grade"]);

        var html = '';
        if(value["statusArr"].length > 0){
            var count = 0;
            $.each(value["statusArr"], function(key, val){
                html += '<tr>'
                    + '<td class="text-center">'+(++count)+'</td>'
                    + '<td class="text-center">'+val["status"]+'</td>'
                    + '</tr>';
            });
        }
        else{
            html = '<tr><td colspan="2" class="text-center">-</td></tr>'
        }

        $("#table2 tbody").html(html);
    }
}