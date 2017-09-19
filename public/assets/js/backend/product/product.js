define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'product/product/index',
                    add_url: 'product/product/add',
                    edit_url: 'product/product/edit',
                    del_url: 'product/product/del',
                    multi_url: 'product/product/multi',
                    table: 'product'
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                searchOnEnterKey : true,
                columns: [
                    [
                        {checkbox: true, operate: false},
                        {field: 'id', title: __('Id'), operate: false},
                        {field: 'product_category_id', title: __('Product_category_id'), operate: false},
                        {field: 'labels', title: __('Labels'), operate: false},
                        {field: 'product_name', title: __('Product_name'), operate: true},
                        //{field: 'status', title: __('Status'), formatter: Table.api.formatter.status, operate: false},
                        {field: 'status_text', title: __('Status_text'), formatter: Table.api.formatter.status_text, operate: false},
                        //{field: 'weigh', title: __('Weigh'), operate: false},
                        {field: 'old_price', title: __('Old_price'), operate: false},
                        {field: 'price', title: __('Price'), operate: false},
                        {field: 'cost', title: __('Cost'), operate: false},
                        {field: 'title', title: __('Title'), operate: true},
                        //{field: 'keywords', title: __('Keywords'), operate: false},
                        {field: 'stock', title: __('Stock'), operate: false},
                        {field: 'sales', title: __('Sales'), operate: false},
                        {field: 'thumbimage', title: __('Thumbimage'), formatter: Table.api.formatter.image, operate: false},
                        //{field: 'galleryimages', title: __('Galleryimages'), formatter: Table.api.formatter.images, operate: false},
                        {field: 'createtime', title: __('Createtime'), formatter: Table.api.formatter.datetime, operate: false},
                        {field: 'updatetime', title: __('Updatetime'), formatter: Table.api.formatter.datetime, operate: false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate, operate: false}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
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