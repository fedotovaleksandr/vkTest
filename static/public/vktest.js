$(function () {
    /**
     *
     * @param object
     *  -datatableid
     *  -field
     *  -url
     *  -helpdata
     * @constructor
     */
    $.MultiSelectButton = function (object) {
        this.tableId = object['tableid'];
        this.field = object['field'];
        this.url = object['url'];
        this.helpdata = object['helpdata'];
    };
    $.MultiSelectButton.prototype.start = function () {
        var data = this.createMultiSelectData();
        if (data.length > 0)
            this.sendData(data);
    }
    $.MultiSelectButton.prototype.createMultiSelectData = function () {
        var tableId = this.tableId;
        var field = this.field;


        var oTT = $.fn.dataTable.TableTools.fnGetInstance(tableId);
        var aData = oTT.fnGetSelectedData();
        var idArray = [];
        for (var row in aData) {
            var id = aData[row][field]
            idArray.push(id);
        }
        ;
        return idArray;
    }
    $.MultiSelectButton.prototype.sendData = function (data) {
        url = this.url;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                ids: data,
                helpdata: this.helpdata
            },
            success: this.successCallback(),
            /*fail: this.errorCallback()*/
        });
    }
    $.MultiSelectButton.prototype.successCallback = function () {
        tableId = this.tableId;

        setTimeout(function () {
            $('#' + tableId).DataTable().draw();
        }, 500);

    }
    $.MultiSelectButton.prototype.errorCallback = function () {
        location.reload();

    }


    $.AjaxButton = function (object) {
        this.tableId = object['tableid'];
        this.field = object['field'];
        this.url = object['url'];
        this.helpdata = object['helpdata'];
        this.data = object['data'];
        this.preaction = object['preaction'];


    };
    $.AjaxButton.prototype = Object.create($.MultiSelectButton.prototype);
    $.AjaxButton.prototype.start = function () {
        var data = this.data;
        if (data.length > 0)
            this.sendData(data);
    }

    $('body').on('click', '.ajaxbutton', function () {

        var url = $(this).data('url');
        var field = $(this).data('field');
        var tableid = $(this).data('tableid');
        var preaction = $(this).data('preaction');

        var row = $(this).closest("tr");
        var table = $('#' + tableid).DataTable();
        var data = table.row(row).data();

        var object = {
            'url': url,
            'data': [data[field]],
            'field': field,
            'tableid': tableid,
            'helpdata': null,
            'preaction':preaction
        };

        var ajaxButton = new $.AjaxButton(object);
        if (window[preaction]())
            ajaxButton.start();
    });

    var forms = document.getElementsByTagName('form');
    for (var i = 0; i < forms.length; i++) {
        forms[i].noValidate = true;

        forms[i].addEventListener('submit', function(event) {
            //Prevent submission if checkValidity on the form returns false.
            if (!event.target.checkValidity()) {
                event.preventDefault();
                //Implement you own means of displaying error messages to the user here.
            }
        }, false);
    }

});