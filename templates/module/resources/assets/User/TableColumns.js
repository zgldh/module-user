export default [
  {data: 'id', name: 'id', title: '用户ID'},
  {data: 'email', name: 'email', title: '邮箱'},
  {data: 'mobile', name: 'mobile', title: '手机号'},
  {data: 'name', name: 'name', title: '姓名（昵称）'},
  {
    data: 'created_at', name: 'created_at', title: '加入时间',
    render: function (created_at) {
      return created_at.substr(0, 10);
    }
  },
  {
    data: 'created_by_admin', name: 'created_by_admin', title: '是否自主创建',
    render: function (created_by_admin) {
      return created_by_admin ? '否' : '是';
    }
  },
  {
    "type": "action",
    "render": function (data, type, row, meta) {
      var html = '<button class="btn btn-default btn-flat edit-item-btn" data-item-id="' + row.id + '"><i class="fa fa-edit"></i> 编辑</button>';
      html += '<button class="btn btn-danger btn-flat delete-item-btn" data-item-id="' + row.id + '"><i class="fa fa-trash"></i> 删除</button>';
      return html;
    }
  },
];