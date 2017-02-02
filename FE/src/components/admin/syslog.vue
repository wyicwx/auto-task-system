<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>系统管理</el-breadcrumb-item>
        <el-breadcrumb-item>运行日志</el-breadcrumb-item>
    </el-breadcrumb>

    <el-table :data="list" style="width: 100%">
        <el-table-column prop="created_time" label="运行时间"></el-table-column>
        <el-table-column prop="times" label="执行任务数目"></el-table-column>
        <el-table-column prop="fail_times" label="失败次数"></el-table-column>
    </el-table>
    <el-pagination
        v-show="pages.pageCount > 1"
        layout="prev, pager, next"
        :page-size="pages.perpage"
        :page-count="pages.pageCount"
        :current-page="pages.page"
        :total="pages.totalCount"
        @current-change="goPage"
    >
    </el-pagination>
</div>
</template>

<script type="text/javascript">
'use strict';

module.exports = {
    data() {
        return {
            page: 1
        }
    },
    computed: {
        list() {
            return this.$store.state.admin.logCrontab.list;
        },
        pages() {
            return this.$store.state.admin.logCrontab.pages;
        }
    },
    created() {
        this.refreshList();
    },
    methods: {
        refreshList() {
            this.$store.dispatch('admin.logcrontab', {
                page: this.page
            });
        },
        goPage(page) {
            this.page = page;
            this.refreshList();
        }
    }
};
</script>