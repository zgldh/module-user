<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>用户权限
        <small v-if="form.id">编辑权限</small>
        <small v-else>新建权限</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>
          <router-link to="/user/permission">用户权限</router-link>
        </li>
        <li class="active" v-if="form.id">编辑权限</li>
        <li class="active" v-else>新建权限</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-default">

        <div class="box-header with-border">
          <el-button type="default" @click="onCancel" icon="close">返回</el-button>
          <el-button type="primary" @click="onSave" icon="check" :loading="saving||loading">
            保存
          </el-button>
        </div>
        <!-- /.box-header -->

        <!-- form start -->
        <div class="box-body">
          <el-alert class="missing-errors" v-if="missingErrors.length" v-for="errorMessage in missingErrors"
                    :key="errorMessage"
                    :title="errorMessage" type="error" show-icon></el-alert>

          <!-- form start -->
          <el-form ref="form" :model="form" label-width="100px" v-loading="loading">
            <el-form-item label="ID" v-if="form.id">
              <el-input v-model="form.id" disabled></el-input>
            </el-form-item>
            <el-form-item label="Name" prop="name" :error="errors.name">
              <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Label" prop="label" :error="errors.label">
              <el-input v-model="form.label"></el-input>
            </el-form-item>
            <el-form-item label="Created At" v-if="form.id">
              <el-input v-model="form.created_at" disabled></el-input>
            </el-form-item>
          </el-form>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <el-button type="default" @click="onCancel" icon="close">返回</el-button>
          <el-button type="primary" @click="onSave" icon="check" :loading="saving||loading">
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
          id: null,
          name: '',
          label: '',
        },
      };
    },
    components: {},
    computed: {
      resource: function () {
        var resourceURL = '/user/permission';
        return (this.form.id ? resourceURL + '/' + this.form.id : resourceURL);
      }
    },
    created: function () {
      this.loading = true;
      let loads = [];
      if (this.$route.params.id) {
        this.form.id = this.$route.params.id;
        loads.push(axios.get(this.resource));
      }

      Promise.all(loads).then(results => {
        this.form = results[0].data.data;
        this.loading = false;
      }).catch(err => {
        this.loading = false;
      });
    },
    methods: {
      onSave: function (event) {
        this._onSave(event).then(result => {
          this.$router.replace('/user/permission/' + result.data.data.id + '/edit');
          this.form = result.data.data;
          this.form.permissions = this.form.permissions.map(permission => permission.id);
        });
      },
      onCancel: function (event) {
        this.$router.back();
      },
    }
  };
</script>

<style lang="scss">

</style>
