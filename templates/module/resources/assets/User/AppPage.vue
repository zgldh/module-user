<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>用户管理
        <small>用户资料记录</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> 总览</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="active">用户资料记录</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary">
        <div class="box-header with-border">
          <button type="button" class="btn btn-flat btn-primary" @click="onCreate">
            <i class="fa fa-plus"></i> 添加用户
          </button>
          <button type="button" class="btn btn-danger btn-flat" :disabled="!selectedItems.length"
                  @click="onBundleDelete"><i class="fa fa-trash"></i> 删除用户
          </button>

          <div class="box-tools">
            <div class="tool-group">
              <span>是否自主创建</span>
              <input type="checkbox" id="created_by_admin-yes" value="0" v-model.number="created_by_admin">
              <label for="created_by_admin-yes">是</label>
              <input type="checkbox" id="created_by_admin-no" value="1" v-model.number="created_by_admin">
              <label for="created_by_admin-no">否</label>
            </div>
            <div class="tool-group">
              <span>是否有待处理记录</span>
              <input type="checkbox" id="pending_data-yes" value="1" v-model.number="pending_data">
              <label for="pending_data-yes">是</label>
              <input type="checkbox" id="pending_data-no" value="0" v-model.number="pending_data">
              <label for="pending_data-no">否</label>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="app-page-table" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="button" class="btn btn-flat btn-primary" @click="onCreate">
            <i class="fa fa-plus"></i> 添加用户
          </button>
          <button type="button" class="btn btn-danger btn-flat" :disabled="!selectedItems.length"
                  @click="onBundleDelete"><i class="fa fa-trash"></i> 删除用户
          </button>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import datatablesHelper from 'resources/assets/js/commons/datatables-helper.js';
  import vueHelper from 'resources/assets/js/commons/vuejs.js';
  import columns from './TableColumns';

  let resourceURL = "/user";
  let datatablesConfig = datatablesHelper.buildDatatablesConfig({
    resource: resourceURL,
    // with: ['roles', 'permissions']
  }, columns);
  let vueConfig = vueHelper.buildVueConfig(resourceURL, datatablesConfig);
  vueConfig.data = function () {
    return {
      resourceURL: resourceURL,
      created_by_admin: [],
      pending_data: []
    };
  };
  vueConfig.watch.created_by_admin = function (val) {
    if (this.created_by_admin.length > 1) {
      this.created_by_admin = [this.created_by_admin.pop()];
    }
    else {
      this.filter();
    }
  };
  vueConfig.watch.pending_data = function (val) {
    // TODO. What is pending data?
  };
  vueConfig.methods.filter = function () {
    var created_by_admin = this.created_by_admin.length ? this.created_by_admin[0] : '';
    this.appPageTable.column('created_by_admin:name').search(created_by_admin, false, false, false)
            .draw();
  };

  export default vueConfig;
</script>

<style lang="scss">
  .box-tools {
    input[type="radio"], input[type="checkbox"] {
      vertical-align: bottom;
    }
    .tool-group {
      display: inline-block;
      margin-left: 1em;
    }
  }
</style>
