<router-treeview title="@lang('module_user::t.title')" icon="fa fa-users" :match="['/user']">
    <router-link tag="li" to="/user/list">
        <a><i class="fa fa-user"></i> <span>@lang('module_user::t.models.user.title')</span></a>
    </router-link>
    <router-link tag="li" to="/user/role">
        <a><i class="fa fa-circle-o"></i> <span>@lang('module_user::t.models.role.title')</span></a>
    </router-link>
    <router-link tag="li" to="/user/permission">
        <a><i class="fa fa-circle-o"></i> <span>@lang('module_user::t.models.permission.title')</span></a>
    </router-link>
</router-treeview>