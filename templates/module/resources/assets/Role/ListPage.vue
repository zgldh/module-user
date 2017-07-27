<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>用户角色
        <small>角色列表</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>用户角色</li>
        <li class="active">角色列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        <div class="box-header with-border">
          <div class="buttons">
            <el-button type="primary" @click="onCreate" icon="plus">添加角色</el-button>
            <el-button type="danger" @click="onBundleDelete" icon="delete" :disabled="selectedItems.length==0">
              删除角色
            </el-button>
          </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body datatable-loading-section">
          <div class="search">
            <el-form :inline="true" :model="searchForm" ref="searchForm">
              <el-form-item label="Name">
                <el-input v-model="searchForm.name" placeholder="Name" column="name" operator="like"></el-input>
              </el-form-item>
              <el-form-item label="Label">
                <el-input v-model="searchForm.label" placeholder="Lable" column="label" operator="like"></el-input>
              </el-form-item>
              <el-form-item>
                <el-button-group>
                  <el-button type="primary" @click="onSubmitSearch">查询</el-button>
                  <el-button type="button" @click="onResetSearch">清空</el-button>
                </el-button-group>
              </el-form-item>
            </el-form>
          </div>

          <div class="datatable-container">
            <!-- 采用 datatables 标准-->
            <el-row class="tools">
              <el-col :span="4">
                <span class="page-size">显示
                <el-select v-model="pagination.pageSize" style="width: 80px"
                           @change="onPageSizeChange">
                  <el-option
                          v-for="item in pagination.pageSizeList"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                  </el-option>
                </el-select>
                  项结果</span>
              </el-col>
              <el-col :span="12">
                <el-pagination
                        @current-change="onPageChange"
                        :current-page="pagination.currentPage"
                        :page-size="pagination.pageSize==-1?1:pagination.pageSize"
                        :layout="pagination.pageSize==-1?'total':'total, prev, pager, next, jumper'"
                        :total="pagination.totalCount">
                </el-pagination>
              </el-col>
              <el-col :span="8">
                <el-input class="auto-search" style="width: 200px;float: right;"
                          placeholder="模糊搜索"
                          v-model="datatablesParameters.search.value"
                          :icon="datatablesParameters.search.value?'close':'search'"
                          :on-icon-click="onAutoSearchIconClick"
                          @change="onAutoSearchChanged">
                </el-input>
              </el-col>
            </el-row>

          </div>
          <div class="datatable" style="margin-top:1em;">
            <el-table
                    :data="tableData"
                    border
                    style="width: 100%"
                    max-height="500"
                    :default-sort="defaultSort"
                    @sort-change="onSortChange"
                    @selection-change="onSelectionChange"
                    ref="table"
            >
              <el-table-column
                      fixed
                      type="selection"
                      width="55">
              </el-table-column>
              <el-table-column
                      prop="name"
                      label="Name"
                      sortable="custom"
                      show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                      prop="label"
                      label="Label"
                      sortable="custom"
                      show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                      prop="created_at"
                      label="Created At"
                      sortable="custom"
                      searchable="false"
                      show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                      fixed="right"
                      label="操作"
                      width="120">
                <template scope="scope">
                  <el-button-group>
                    <el-button @click="onEditClick(scope.row,scope.column,scope.$index,scope.store)" type="default"
                               size="small" icon="edit" title="编辑"></el-button>
                    <el-button @click="onDeleteClick(scope.row,scope.column,scope.$index,scope.store)" type="danger"
                               size="small" icon="delete" title="删除"></el-button>
                  </el-button-group>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <el-button type="primary" @click="onCreate" icon="plus">添加角色</el-button>
          <el-button type="danger" @click="onBundleDelete" icon="delete" :disabled="selectedItems.length==0">
            删除角色
          </el-button>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import {mixin} from "resources/assets/js/commons/ListHelpers.js";

  export default {
    mixins: [mixin],
    data: function () {
      let data = {
        resource: '/user/role',
        datatablesParameters: {
          order: [{column: 'name', dir: 'asc'}],
        },
        searchForm: {
          name: null,
          label: null
        }
      };
      return data;
    },
    methods: {
      onCreate: function () {
        return this.$router.push('/user/role/create');
      },
      onEditClick: function (row, column, $index, store) {
        return this.$router.push('/user/role/' + row.id + '/edit');
      },
      onDeleteClick: function (row, column, $index, store) {
        return this._onDeleteClick({
          url: '/user/role/' + row.id,
          params: {},
          confirmText: '确认要删除吗？',
          messageText: '删除完毕'
        }).then(result => {
          this.tableData.splice($index, 1);
          this.pagination.totalCount--;
        });
      },
      onBundleDelete: function () {
        return this.$confirm("确认要删除 " + this.selectedItems.length + " 项角色么？", '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          return this._onBundle('delete');
        }).then(result => {
          this.$message({
            type: 'success',
            message: "删除完毕"
          });
          return this.queryTableData();
        });
      },
    }
  };

</script>

<style lang="scss">

</style>
