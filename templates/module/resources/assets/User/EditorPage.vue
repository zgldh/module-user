<template>
  <div class="admin-editor-page">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{$t('module_user.models.user.title')}}
        <small v-if="form.id">{{$t('scaffold.terms.edit')}}</small>
        <small v-else>{{$t('scaffold.terms.create')}}</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> {{$t('module_dashboard.title')}}</router-link>
        </li>
        <li>
          <router-link to="/user/list">{{$t('module_user.models.user.title')}}</router-link>
        </li>
        <li class="active" v-if="form.id">{{$t('scaffold.terms.edit')}}</li>
        <li class="active" v-else>{{$t('scaffold.terms.create')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-default">

        <div class="box-header with-border">
          <el-button type="default" @click="onCancel" icon="close">{{$t('scaffold.terms.back')}}</el-button>
          <el-button type="primary" @click="onSave" icon="check" :loading="saving||loading">
            {{$t('scaffold.terms.save')}}
          </el-button>
        </div>
        <!-- /.box-header -->

        <!-- form start -->
        <div class="box-body">
          <el-alert class="missing-errors" v-if="missingErrors.length" v-for="errorMessage in missingErrors"
                    :key="errorMessage"
                    :title="errorMessage" type="error" show-icon></el-alert>

          <!-- form start -->
          <el-form ref="form" :model="form" label-width="200px" v-loading="loading">
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
                <el-radio label="female">女 Female</el-radio>
              </el-radio-group>
            </el-form-item>

            <el-form-item label="Avatar" prop="avatar" :error="errors.avatar">
              <single-image-upload-component v-model="form.avatar_id"
                                             :data="{type:'avatar'}"></single-image-upload-component>
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

            <el-form-item label="Roles" prop="roles" :error="errors.roles">
              <el-select class="role-selector" v-model="form.roles" filterable multiple>
                <el-option
                        v-for="role in roles"
                        :key="role.id"
                        :label="role.label"
                        :value="role.id">
                </el-option>
              </el-select>
            </el-form-item>

            <el-form-item label="Permissions" prop="permissions" :error="errors.permissions">
              <el-select class="permission-selector" v-model="form.permissions" filterable multiple>
                <el-option
                        v-for="permission in permissions"
                        :key="permission.id"
                        :label="permission.label"
                        :value="permission.id">
                </el-option>
              </el-select>
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
          <el-button type="default" @click="onCancel" icon="close">{{$t('scaffold.terms.back')}}</el-button>
          <el-button type="primary" @click="onSave" icon="check" :loading="saving||loading">
            {{$t('scaffold.terms.save')}}
          </el-button>
        </div>

      </div>

    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import { mixin } from "resources/assets/js/commons/EditorHelper.js";
  import { loadModuleLanguage } from 'resources/assets/js/commons/LanguageHelper';
  import SingleImageUploadComponent from 'Modules/Upload/resources/assets/SingleImageUploadComponent.vue';

  export default  {
    mixins: [
      mixin,
      loadModuleLanguage('module_user')
    ],
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
          last_login_at: null,
          login_times: 0,
          avatar_id: null,  //如果这个参数是该数据表内有的字段，则写字段名，否则写关系名
          roles: [],
          permissions: []
        },
        roles: [],
        permissions: []
      };
    },
    components: {
      SingleImageUploadComponent
    },
    computed: {
      resource: function () {
        var resourceURL = '/user';
        return (this.form.id ? resourceURL + '/' + this.form.id : resourceURL) + '?_with=roles,permissions';
      }
    },
    created: function () {
      this.loading = true;
      let loads = [
        axios.get('/user/role'),
        axios.get('/user/permission')
      ];
      if (this.$route.params.id) {
        this.form.id = this.$route.params.id;
        loads.push(axios.get(this.resource));
      }

      Promise.all(loads).then(results => {
        this.roles = results[0].data.data;
        this.permissions = results[1].data.data;
        if (results.length > 2) {
          this.form = results[2].data.data;
          this.form.roles = this.form.roles.map(role => role.id);
          this.form.permissions = this.form.permissions.map(permission => permission.id);
        }
        this.loading = false;
      }).catch(err => {
        this.loading = false;
      });
    },
    methods: {
      onSave: function (event) {
        this._onSave(event).then(result => {
          this.$router.replace('/user/' + result.data.data.id + '/edit');
          this.form = result.data.data;
          this.form.roles = this.form.roles.map(role => role.id);
          this.form.permissions = this.form.permissions.map(permission => permission.id);
        });
      },
      onCancel: function (event) {
        this.$router.back();
      },
    }
  };
</script>

<style lang="scss" scoped>
  .role-selector, .permission-selector {
    width: 100%;
  }
</style>
