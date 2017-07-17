<template>
  <div class="admin-list-page">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>用户管理
        <small>用户资料记录</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>用户管理</li>
        <li class="active">用户资料记录</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        <div class="box-header with-border">
          <div class="buttons">
            <el-button type="primary" @click="onCreate"><i class="fa fa-plus"></i> 添加用户</el-button>
            <el-button type="danger" @click="onBundleDelete" :disabled="!selectedItems.length"><i
                    class="fa fa-trash"></i>
              删除用户
            </el-button>
          </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body datatable-loading-section">
          <div class="search">
            <el-form :inline="true" :model="searchForm">
              <el-form-item label="审批人">
                <el-input v-model="searchForm.user" placeholder="审批人"></el-input>
              </el-form-item>
              <el-form-item label="审批人">
                <el-input v-model="searchForm.user" placeholder="审批人"></el-input>
              </el-form-item>
              <el-form-item label="审批人">
                <el-input v-model="searchForm.user" placeholder="审批人"></el-input>
              </el-form-item>

              <el-form-item label="活动区域">
                <el-select v-model="searchForm.region" placeholder="活动区域">
                  <el-option label="区域一" value="shanghai"></el-option>
                  <el-option label="区域二" value="beijing"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" @click="onSubmitSearch">查询</el-button>
              </el-form-item>
            </el-form>
          </div>

          <div class="datatable-container">
            <!-- 采用 datatables 标准-->
            <el-row class="tools">
              <el-col :span="4">
                <span class="page-size">显示
                <el-select v-model="pagination.pageSize" style="width: 80px"
                           @change="handleSizeChange">
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
                        @current-change="handlePageChange"
                        :current-page="pagination.currentPage"
                        :page-size="pagination.pageSize==-1?1:pagination.pageSize"
                        :layout="pagination.pageSize==-1?'total':'total, prev, pager, next, jumper'"
                        :total="pagination.totalCount">
                </el-pagination>
              </el-col>
              <el-col :span="8">
                <el-input class="auto-search" style="width: 200px;float: right;"
                          placeholder="模糊搜索"
                          icon="search"
                          v-model="searchTerm">
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
                    :default-sort="{prop: 'date', order: 'descending'}"
                    @sort-change="onSortChange"
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
                      show-overflow-tooltip
                      width="180">
              </el-table-column>
              <el-table-column
                      prop="email"
                      label="Email"
                      sortable="custom"
                      show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                      prop="is_active"
                      label="Is Active"
                      sortable="custom"
                      show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                      prop="last_login_at"
                      label="Last Login"
                      sortable="custom"
                      show-overflow-tooltip>
                <template scope="scope">
                  <el-tag v-if="scope.row.last_login_at">{{ scope.row.last_login_at }}</el-tag>
                  <el-tag type="grey" v-if="scope.row.login_times">{{ scope.row.login_times }}</el-tag>
                </template>
              </el-table-column>
              <el-table-column
                      prop="created_at"
                      label="Created At"
                      sortable="custom"
                      show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                      fixed="right"
                      label="操作"
                      width="100">
                <template scope="scope">
                  <el-button @click="handleClick" type="text" size="small">查看</el-button>
                  <el-button type="text" size="small">编辑</el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <el-button type="primary" @click="onCreate"><i class="fa fa-plus"></i> 添加用户</el-button>
          <el-button type="danger" @click="onBundleDelete" :disabled="!selectedItems.length"><i class="fa fa-trash"></i>
            删除用户
          </el-button>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import { mixin } from "resources/assets/js/commons/ListHelpers.js";

  export default {
    mixins: [mixin],
    data: function () {
      let data = {
        resource: '/user',
        datatablesParameters: {
          order: [{column: 'name', dir: 'desc'}],
        }
      };
      return data;
    },
    methods: {}
  };

</script>

<style lang="scss">
  .search {
    margin-top: 1em;
  }
</style>
