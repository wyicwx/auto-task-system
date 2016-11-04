<template>
<div class="p_dashboard">
    <div class="sider">
        <el-menu theme="dark" :router="true">
            <el-menu-item index="/dashboard">
                <i class="el-icon-menu"></i>控制台
            </el-menu-item>

            <el-submenu index="/task">
                <template slot="title"><i class="el-icon-date"></i>任务</template>
                <el-menu-item index="/model/market">
                    模板商店
                </el-menu-item>
                <el-menu-item index="/task/list">
                    我的任务
                </el-menu-item>
                <el-menu-item index="/model/list">
                    我的模板
                </el-menu-item>
            </el-submenu>

            <el-submenu index="/statistics">
                <template slot="title">
                    <i class="el-icon-information"></i>数据统计
                </template>
                <el-menu-item index="/statistics/task">
                    任务状况
                </el-menu-item>
                <el-menu-item index="/statistics/model">
                    模板状况
                </el-menu-item>
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

            <el-menu-item index="/logout" @click="logout">
                <i class="el-icon-upload2"></i>退出
            </el-menu-item>
        </el-menu>
    </div>
    <div class="main" :style="{minHeight: minHeight + 'px'}">
        <el-row>
            <el-col :span="24">
                <router-view></router-view>
            </el-col>
        </el-row>
    </div>
</div>
    
</template>

<script type="text/javascript">
'use strict';

module.exports = {
    data() {
        return {
            minHeight: 0
        }
    },
    methods: {
        logout() {
            debugger;
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
    }
};
</script>