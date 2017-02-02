<template>
<div class="p_dashboard">
    <div class="sider">
        <el-menu theme="dark" :router="true">
            <!-- <el-menu-item index="/dashboard">
                <i class="el-icon-menu"></i>控制台
            </el-menu-item> -->
            <el-submenu index="/task">
                <template slot="title"><i class="el-icon-date"></i>控制台</template>
                <el-menu-item index="/task/list">
                    我的任务
                </el-menu-item>
                <el-menu-item index="/model/list">
                    我的模板
                </el-menu-item>
                <el-menu-item index="/model/market">
                    公开模板
                </el-menu-item>
            </el-submenu>

            <el-submenu index="/statistics">
                <template slot="title">
                    <i class="el-icon-information"></i>数据统计
                </template>
                <el-menu-item index="/statistics/task">
                    任务状况
                </el-menu-item>
                <!-- <el-menu-item index="/statistics/model">
                    模板状况
                </el-menu-item> -->
            </el-submenu>

            <el-submenu index="/user">
                <template slot="title">
                    <i class="el-icon-setting"></i>设置
                </template>
                <el-menu-item index="/user/profile">
                    修改资料
                </el-menu-item>
                <el-menu-item index="/user/password">
                    修改密码
                </el-menu-item>
            </el-submenu>

            <el-submenu index="/admin" v-if="user.role == 1">
                <template slot="title">
                    <i class="el-icon-menu"></i>系统管理
                </template>
                <el-menu-item index="/admin/adduser">
                    增加用户
                </el-menu-item>
                <el-menu-item index="/admin/resetpassword">
                    重置密码
                </el-menu-item>
                <el-menu-item index="/admin/syslog">
                    运行日志
                </el-menu-item>
            </el-submenu>

            <el-menu-item index="" @click="logout">
                <span href="javascript:void(0)" @click="logout">
                    <i class="el-icon-upload2"></i>退出
                </span>
            </el-menu-item>
        </el-menu>
    </div>
    <div class="main" :style="{minHeight: minHeight + 'px'}">
        <el-row style="height: 100%;">
            <el-col :span="24" style="height: 100%;">
                <router-view></router-view>
            </el-col>
        </el-row>
    </div>
    <div class="fetch_loading" v-if="fetchLoading">
        <i class="el-icon-loading"></i>
    </div>
</div>
    
</template>

<script type="text/javascript">
'use strict';

var { EventEmitter } = require('fbemitter');

module.exports = {
    data() {
        return {
            minHeight: 0,
            user: this.$store.state.user,
            fetchLoading: this.$store.state.fetchLoading
        }
    },
    methods: {
        logout() {
            this.$confirm('确定退出?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                location.href = '/site/logout';
            }).catch(() => {});
        },
        calcMinHeight() {
            this.minHeight = window.innerHeight;
        }
    },
    mounted() {
        this.calcMinHeight();

        window.addEventListener('resize', () => {
            this.calcMinHeight();
        });

        EventEmitter.emitter.addListener('fetch.start', () => {
            this.fetchLoading = true;
        });

        EventEmitter.emitter.addListener('fetch.end', () => {
            this.fetchLoading = false;
        });
    }
};
</script>