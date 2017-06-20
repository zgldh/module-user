<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>管理员角色
        <small>角色列表</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> 总览</a></li>
        <li><a href="#">管理员角色</a></li>
        <li class="active">角色列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary">
        <div class="box-header with-border">
          <button type="button" class="btn btn-flat btn-primary" @click="onCreate"><i class="fa fa-plus"></i> 新增
          </button>
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
          <button type="button" class="btn btn-flat btn-primary" @click="onCreate"><i class="fa fa-plus"></i> 新增
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

  let resourceURL = "/admin/role";
  let datatablesConfig = datatablesHelper.buildDatatablesConfig({
    resource: resourceURL,
    with: ['permissions']
  }, columns);
  let vueConfig = vueHelper.buildVueConfig(resourceURL, datatablesConfig);

  export default vueConfig;
</script>

<style lang="scss">

</style>
