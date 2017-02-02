<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>系统管理</el-breadcrumb-item>
        <el-breadcrumb-item>重置密码</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form ref="form" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="邮箱">
                    <el-input v-model="email" placeholder="请输入邮箱"></el-input>
                </el-form-item>
            </el-col>
        </el-row>

        <el-form-item>
            <el-button type="success" @click="save">保存</el-button>
        </el-form-item>
    </el-form>
</div>
</template>

<script type="text/javascript">
'use strict';

module.exports = {
    data() {
        return {
            email: ''
        }
    },
    methods: {
        save() {
            this.$store.dispatch('admin.resetpassword', {
                email: this.email
            });
        }
    }
};
</script>