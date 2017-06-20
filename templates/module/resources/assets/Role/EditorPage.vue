<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>管理员角色
        <small v-if="item.id">编辑角色</small>
        <small v-else>新建角色</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>
          <router-link to="/admin/role">管理员角色</router-link>
        </li>
        <li class="active" v-if="item.id">编辑角色</li>
        <li class="active" v-else>新建角色</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary">
        <!--<div class="box-header with-border">-->
        <!--</div>-->
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">

          <form class="form-horizontal" @submit="onSave">
            <div class="form-group" :class="{'has-error': item.$errors.has('name')}">
              <label for="name" class="col-sm-2 control-label">角色英文标识 <span class="error">*</span></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" v-model="item.name">
                <span class="help-block"
                      v-if="item.$errors.has('name')">{{item.$errors.get('name')}}</span>
              </div>
            </div>
            <div class="form-group" :class="{'has-error': item.$errors.has('label')}">
              <label for="label" class="col-sm-2 control-label">角色名 <span class="error">*</span></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="label" v-model="item.label">
                <span class="help-block"
                      v-if="item.$errors.has('label')">{{item.$errors.get('label')}}</span>
              </div>
            </div>
            <div class="form-group" :class="{'has-error': item.$errors.has('permissions')}">
              <label for="permissions" class="col-sm-2 control-label">权限</label>
              <div class="col-sm-10">
                <v-select class="form-control" id="permissions"
                          data-tags="true" placeholder="选择权限"
                          v-model="item.permissions"
                          :options="permissions"
                          valueKey="id"
                          :multiple="true">
                </v-select>
                <span class="help-block"
                      v-if="item.$errors.has('permissions')">{{item.$errors.get('permissions')}}</span>
              </div>
            </div>
          </form>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <router-link-back class="btn btn-lg btn-flat btn-default pull-left">返回</router-link-back>
          <button type="submit" form="editing-form" class="btn btn-lg btn-flat btn-primary" @click="onSave"
                  :disabled="saving">
            {{saving?"保存中...":"保存"}}
          </button>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import {Vue} from 'resources/assets/js/commons/vuejs.js';
  import {alert} from 'resources/assets/js/components/SweetAlertDialogs';
  import ErrorsBuilder from 'resources/assets/js/commons/ErrorsBuilder.js';

  var resourceURL = "/admin/role";
  var resource = Vue.resource(resourceURL + '{/id}?_with=permissions');
  var vueConfig = {
    data: function () {
      return {
        item: {
          id: null,
          name: '',
          label: '',
          permissions: [],
          $errors: ErrorsBuilder()
        },
        saving: false,
        permissions: []
      };
    },
    beforeRouteEnter (to, from, next) {
      var permissions = [];
      return Vue.http.get('/admin/permission').then(function (result) {
        permissions = result.data.data;
        if (to.params.id) {
          return resource.get({id: to.params.id});
        }
        else {
          return {data: {data: null}};
        }
      }.bind(this)).then(function (result) {
        next(function (vm) {
          vm.permissions = permissions;
          if (result.data.data) {
            vm.item = result.data.data;
            vm.item.$errors = ErrorsBuilder();
          }
        })
      }).catch(function (err) {
        next(false);
      });
    },
    methods: {
      onSave: function (event) {
        this.saving = true;
        this.item.$errors.removeAll();

        var promise = null;
        let payload = $.extend(true, {}, this.item);
        payload.permissions = payload.permissions.map(function (permission) {
          return typeof(permission) == 'number' ? permission : permission.id;
        });
        if (payload.id) {
          promise = resource.update({id: payload.id}, payload).then(function (result) {
            window.toastr["success"]("编辑已保存");
            return result.data.data;
          });
        }
        else {
          promise = resource.save(payload).then(function (result) {
            window.toastr["success"]("新增成功");
            return result.data.data;
          });
        }

        promise.then(function (data) {
          return resource.get({id: data.id});
        }).then(function (result) {
          this.saving = false;
          this.item = result.data.data;
          this.item.$errors = ErrorsBuilder();
        }.bind(this)).catch(function (err) {
          this.saving = false;
          if (err.status == 422) {
            this.item.$errors.setAll(err.body);
            this.item.$errors.focusFirstErrorField();
          }
          else {
            alert(err.data.message);
          }
        }.bind(this));

        return false;
      },
    }
  };
  export default vueConfig;

</script>

<style lang="scss">

</style>
