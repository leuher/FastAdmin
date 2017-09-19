define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'product/attr/index',
                    add_url: 'product/attr/add',
                    edit_url: 'product/attr/edit',
					addson_url: 'product/attr/addson',
                    del_url: 'product/attr/delete',
                    multi_url: 'product/attr/multi',
                    table: 'product_attr',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        //{field: 'pid', title: __('Pid')},
                        {field: 'category_id', title: __('Category_id')},
                        {field: 'name', title: __('Name')},
                        {field: 'time', title: __('Time'), formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table,buttons:Array({name: 'addson', icon: 'fa fa-plus', classname: 'btn btn-xs btn-success btn-addson'}), events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        addson: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});