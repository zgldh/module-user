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
          <el-form ref="form" :model="form" label-width="80px" v-loading="loading">
            <el-form-item label="ID" v-if="form.id">
              <el-input v-model="form.id" disabled></el-input>
            </el-form-item>
            <el-form-item label="Name" prop="name" :error="errors.name">
              <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Email" prop="email" :error="errors.email">
              <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item label="Password" prop="password" :error="errors.password">
              <el-input v-model="form.password" type="password"></el-input>
              <p class="assist-tip" v-if="form.id">不想修改密码则留空</p>
            </el-form-item>
            <el-form-item label="Gender" prop="gender" :error="errors.gender">
              <el-radio-group v-model="form.gender">
                <el-radio label="male">男 Male</el-radio>
                <el-radio label="femal">女 Female</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="Mobile" prop="mobile" :error="errors.mobile">
              <el-input v-model="form.mobile"></el-input>
            </el-form-item>
            <el-form-item label="Is Active" prop="is_active" :error="errors.is_active">
              <el-radio-group v-model="form.is_active">
                <el-radio :label="1">Active</el-radio>
                <el-radio :label="0">Inactive</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="Last Login At" v-if="form.id">
              <el-input v-model="form.last_login_at" disabled></el-input>
            </el-form-item>
            <el-form-item label="Login Times" v-if="form.id">
              <el-input v-model="form.login_times" disabled></el-input>
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
          email: '',
          password: '',
          gender: 'male',
          mobile: '',
          is_active: 1,
          last_login_at: '',
          login_times: 0,
          avatar: null,
        }
      };
    },
    components: {},
    computed: {
      resource: function () {
        var resourceURL = '/user';
        return this.form.id ? resourceURL + '/' + this.form.id : resourceURL;
      }
    },
    created: function () {
      if (this.$route.params.id) {
        this.loading = true;
        this.form.id = this.$route.params.id;
        return axios.get(this.resource)
                .then((result) => {
                  if (result.data.data) {
                    this.form = result.data.data;
                  }
                  this.loading = false;
                })
                .catch(function (err) {
                  this.loading = false;
                });
      }
    },
    methods: {
      onCancel: function (event) {
        return this.$router.push('/user');
      },
    }
  };
</script>

<style lang="scss">

</style>
