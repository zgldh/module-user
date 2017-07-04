<template>
  <div class="admin-editor-page">
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
            <div class="form-group" :class="{'has-error': item.$errors.has('avatar')}">
              <label for="field-avatar" class="col-sm-2 control-label">头像</label>
              <div class="col-sm-10">
                <!--<upload-file class="form-control" id="field-avatar" v-model="item.avatar"></upload-file>-->
                <span class="help-block">支持≤3MB，JPG、JPEG、PNG格式文件</span>
                <span class="help-block" v-if="item.$errors.has('avatar')">{{item.$errors.get('avatar')}}</span>
              </div>
            </div>
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

  var resource = Vue.resource('/user{/id}?_with=avatar');
  export default  {
    data: function () {
      return {};
    },
    components: {},
    beforeRouteEnter (to, from, next) {
      if (to.params.id) {
        return resource.get({id: to.params.id}).then(function (result) {
          next(function (vm) {
            if (result.data.data) {
              vm.item = result.data.data;
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
</script>

<style lang="scss">

</style>
