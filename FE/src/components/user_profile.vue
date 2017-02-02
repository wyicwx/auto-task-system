<template>
<div v-loading="user.loading" style="height: 100%">
    <div v-if="!user.loading">    
        <el-breadcrumb separator="/" class="mb20">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>设置</el-breadcrumb-item>
            <el-breadcrumb-item>修改资料</el-breadcrumb-item>
        </el-breadcrumb>
        <el-form ref="form" label-width="80px">
            <el-row>
                <el-col :span="12">
                    <el-form-item label="头像">
                        <img :src="user.avatar" class="vat dis_b" />

                        <div>
                            <a href="http://en.gravatar.com/" target="_blank">访问Gravatar修改头像</a>
                        </div>
                    </el-form-item>
                    <el-form-item label="昵称">
                        <el-input v-model="user.nickname" placeholder="请输入昵称"></el-input>
                    </el-form-item>
                    <el-form-item label="电子邮箱">
                        <el-input v-model="user.email" placeholder="请输入电子邮箱"></el-input>
                    </el-form-item>
                    <!-- <el-form-item label="邮件通知">
                        <el-switch
                          v-model="emailNotice"
                          on-color="#13ce66"
                          off-color="gray">
                        </el-switch>
                    </el-form-item> -->
                </el-col>
            </el-row>

            <el-form-item>
                <el-button type="success" @click="save">保存</el-button>
            </el-form-item>
        </el-form>
    </div>
</div>
</template>

<script type="text/javascript">
'use strict';

module.exports = {
    data() {
        return {}
    },
    computed: {
        user() {
            return this.$store.state.user;
        }
    },
    created() {
        this.$store.dispatch('user.profile');
    },
    methods: {
        save() {
            this.$store.dispatch('user.updateProfile', this.user);
        }
    }
};
</script>