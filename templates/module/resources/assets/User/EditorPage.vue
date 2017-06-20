<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>用户管理
        <small v-if="item.id">查看用户</small>
        <small v-else>新建用户</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>
          <router-link to="/user">用户管理</router-link>
        </li>
        <li class="active" v-if="item.id">查看用户</li>
        <li class="active" v-else>新建用户</li>
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
            <div class="form-group" v-if="item.id">
              <label for="id" class="col-sm-2 control-label">用户ID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="id" v-bind:value="item.id" disabled>
              </div>
            </div>
            <div class="form-group" :class="{'has-error': item.$errors.has('email')}">
              <label for="email" class="col-sm-2 control-label">邮箱 <span class="error">*</span></label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" v-model="item.email">
                <span class="help-block"
                      v-if="item.$errors.has('email')">{{item.$errors.get('email')}}</span>
              </div>
            </div>
            <div class="form-group" :class="{'has-error': item.$errors.has('mobile')}">
              <label for="mobile" class="col-sm-2 control-label">手机号</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="mobile" v-model="item.mobile">
                <span class="help-block"
                      v-if="item.$errors.has('mobile')">{{item.$errors.get('mobile')}}</span>
              </div>
            </div>
            <div class="form-group" :class="{'has-error': item.$errors.has('name')}">
              <label for="name" class="col-sm-2 control-label">姓名（昵称）<span class="error">*</span></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" v-model="item.name">
                <span class="help-block"
                      v-if="item.$errors.has('name')">{{item.$errors.get('name')}}</span>
              </div>
            </div>
            <!--<div class="form-group" :class="{'has-error': item.$errors.has('gender')}">-->
              <!--<label for="field-gender" class="col-sm-2 control-label">性别</label>-->
              <!--<div class="col-sm-10">-->
                <!--<label class="radio-inline">-->
                  <!--<input type="radio" id="field-gender-Male" value="Male"-->
                         <!--v-model="item.gender">男-->
                <!--</label>-->
                <!--<label class="radio-inline">-->
                  <!--<input type="radio" id="field-gender-Female" value="Female"-->
                         <!--v-model="item.gender">女-->
                <!--</label>-->
                <!--<span class="help-block"-->
                      <!--v-if="item.$errors.has('gender')">{{item.$errors.get('gender')}}</span>-->
              <!--</div>-->
            <!--</div>-->
            <div class="form-group" :class="{'has-error': item.$errors.has('avatar')}">
              <label for="field-avatar" class="col-sm-2 control-label">头像</label>
              <div class="col-sm-10">
                <!--<upload-file class="form-control" id="field-avatar" v-model="item.avatar"></upload-file>-->
                <image-preview
                        :enable-upload="true"
                        v-model="item.avatar"
                        name="cover"
                        :action="'/upload'"
                        label="" style="height: 200px; width: 200px;" id="field-avatar">
                </image-preview>
                <span class="help-block">支持≤3MB，JPG、JPEG、PNG格式文件</span>
                <span class="help-block" v-if="item.$errors.has('avatar')">{{item.$errors.get('avatar')}}</span>
              </div>
            </div>
            <!--<div class="form-group" :class="{'has-error': item.$errors.has('is_active')}">-->
            <!--<label for="field-is_active" class="col-sm-2 control-label">激活</label>-->
            <!--<div class="col-sm-10">-->
            <!--<label class="radio-inline">-->
            <!--<input type="radio" id="field-is_active-1" value="1"-->
            <!--v-model="item.is_active">激活-->
            <!--</label>-->
            <!--<label class="radio-inline">-->
            <!--<input type="radio" id="field-is_active-2" value="2"-->
            <!--v-model="item.is_active">禁用-->
            <!--</label>-->
            <!--<span class="help-block" v-if="item.$errors.has('is_active')">{{item.$errors.get('is_active')}}</span>-->
            <!--</div>-->
            <!--</div>-->
            <div class="form-group" :class="{'has-error': item.$errors.has('password')}">
              <label for="password" class="col-sm-2 control-label">密码 <span class="error">*</span></label>

              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" :placeholder="item.id?'不变则留空':''"
                       v-model="item.password">
                <span class="help-block"
                      v-if="item.$errors.has('password')">{{item.$errors.get('password')}}</span>
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
  import ImagePreview from 'resources/assets/js/components/ImagePreview.vue';

  var resourceURL = "/user";
  // var resource = Vue.resource(resourceURL + '{/id}');
  var resource = Vue.resource(resourceURL + '{/id}?_with=avatar');
  var vueConfig = {
    data: function () {
      return {
        item: {
          id: null,
          name: '',
          email: '',
          password: null,
          // roles: [],
          // permissions: [],
          gender: 'Male',
          avatar: null,
          mobile: null,
          is_active: 1,
          region: '中国',
          $errors: ErrorsBuilder()
        },
        saving: false,
        // permissions: [],
        // roles: [],
      };
    },
    components: {
      'image-preview': ImagePreview
    },
    beforeRouteEnter (to, from, next) {
      if (to.params.id) {
        return resource.get({id: to.params.id}).then(function (result) {
          next(function (vm) {
            if (result.data.data) {
              vm.item = result.data.data;
              vm.item.$errors = ErrorsBuilder();
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
        var vm = this;
        this.saving = true;
        this.item.$errors.removeAll();

        var promise = null;
        let payload = $.extend(true, {}, this.item);
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
          vm.$router.back();
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
