<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>设置</el-breadcrumb-item>
        <el-breadcrumb-item>修改密码</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form ref="form" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="旧密码">
                    <el-input type="password" v-model="password" placeholder="请输入旧密码"></el-input>
                </el-form-item>
                <el-form-item label="新密码">
                    <el-input type="password" v-model="newpassword" placeholder="请输入新密码"></el-input>
                </el-form-item>
                <el-form-item label="重复密码">
                    <el-input type="password" v-model="repassword" placeholder="请输入重复密码"></el-input>
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
            password: '',
            newpassword: '',
            repassword: ''
        }
    },
    methods: {
        save() {
            this.$store.dispatch('user.password', {
                password: this.password,
                newpassword: this.newpassword,
                repassword: this.repassword
            });
        }
    }
};
</script>