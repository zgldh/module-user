<template>
  <div class="admin-editor-page">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>用户管理
        <small v-if="form.id">查看用户</small>
        <small v-else>新建用户</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>
          <router-link to="/user">用户管理</router-link>
        </li>
        <li class="active" v-if="form.id">查看用户</li>
        <li class="active" v-else>新建用户</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-default">

        <div class="box-header with-border">
          <el-button type="default" @click="onCancel" icon="close">返回</el-button>
          <el-button type="primary" @click="onSave" icon="check" :disabled="saving">
            保存
          </el-button>
        </div>
        <!-- /.box-header -->

        <!-- form start -->
        <div class="box-body">
          <!-- form start -->
          <el-form ref="form" :model="form" label-width="80px">
            <el-form-item label="活动名称">
              <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="活动区域">
              <el-select v-model="form.region" placeholder="请选择活动区域">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="活动时间">
              <el-col :span="11">
                <el-date-picker type="date" placeholder="选择日期" v-model="form.date1"
                                style="width: 100%;"></el-date-picker>
              </el-col>
              <el-col class="line" :span="2">-</el-col>
              <el-col :span="11">
                <el-time-picker type="fixed-time" placeholder="选择时间" v-model="form.date2"
                                style="width: 100%;"></el-time-picker>
              </el-col>
            </el-form-item>
            <el-form-item label="即时配送">
              <el-switch on-text="" off-text="" v-model="form.delivery"></el-switch>
            </el-form-item>
            <el-form-item label="活动性质">
              <el-checkbox-group v-model="form.type">
                <el-checkbox label="美食/餐厅线上活动" name="type"></el-checkbox>
                <el-checkbox label="地推活动" name="type"></el-checkbox>
                <el-checkbox label="线下主题活动" name="type"></el-checkbox>
                <el-checkbox label="单纯品牌曝光" name="type"></el-checkbox>
              </el-checkbox-group>
            </el-form-item>
            <el-form-item label="特殊资源">
              <el-radio-group v-model="form.resource">
                <el-radio label="线上品牌商赞助"></el-radio>
                <el-radio label="线下场地免费"></el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="活动形式">
              <el-input type="textarea" v-model="form.desc"></el-input>
            </el-form-item>
            <el-form-item>
            </el-form-item>
          </el-form>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <el-button type="default" @click="onCancel" icon="close">返回</el-button>
          <el-button type="primary" @click="onSave" icon="check" :disabled="saving">
            保存
          </el-button>
        </div>

      </div>

    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import {mixin} from "resources/assets/js/commons/EditorHelper.js";

  // var resource = Vue.resource('/user{/id}?_with=avatar');
  export default  {
    mixins: [mixin],
    data: function () {
      return {
        form: {
          name: '',
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        },
        saving: false
      };
    },
    components: {},
    beforeRouteEnter (to, from, next) {
      if (to.params.id) {
        return resource.get({id: to.params.id}).then(function (result) {
          next(function (vm) {
            if (result.data.data) {
              vm.form = result.data.data;
            }
          });
        }).catch(function (err) {
          next(false);
        });
      }
      else {
        next();
      }
    },
    methods: {
      onSave: function (event) {
      },
      onCancel: function (event) {
        return this.$router.push('/user');
      },
    }
  };
</script>

<style lang="scss">

</style>
