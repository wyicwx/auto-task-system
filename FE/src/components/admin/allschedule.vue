<template>
<div v-loading="list.loading" style="height: 100%">
    <div v-if="!list.loading">    
        <el-breadcrumb separator="/" class="mb20">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>系统管理</el-breadcrumb-item>
            <el-breadcrumb-item>任务状况</el-breadcrumb-item>
        </el-breadcrumb>
        <el-table :data="list.list" style="width: 100%">
            <el-table-column prop="update_time" label="更新时间" width="180"></el-table-column>
            <el-table-column align="center" label="执行状态" width="100">
                <template scope="scope">
                    <el-tag :close-transition="true" type="success" v-if="scope.row.status == 0">成功</el-tag>
                    <el-tag :close-transition="true" type="danger" v-if="scope.row.status == 1">失败</el-tag>
                    <el-tag :close-transition="true" type="gray" v-if="scope.row.status == 2">未执行</el-tag>
                    <el-tag :close-transition="true" v-if="scope.row.status == 3">终止</el-tag>
                    <el-tag :close-transition="true" type="warning" v-if="scope.row.status == 4">重试未执行</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="代码模板">
                <template scope="scope">
                    <router-link :to="'/model/view/'+scope.row.model.id" target="_blank">{{scope.row.model.name}}</router-link>
                </template>
            </el-table-column>
            <el-table-column align="center" label="重试次数" width="100">
                <template scope="scope">
                    {{scope.row.times == '0' ? '--' : scope.row.times}}
                </template>
            </el-table-column>
            <el-table-column align="center" label="执行结果" width="100">
                <template scope="scope">
                    <a href="javascript:void(0)" v-if="scope.row.status == 1 || scope.row.status == 4" @click="showDetail(scope.row.result)">查看详情</a>
                </template>
            </el-table-column>
            <el-table-column label="用户" width="100" prop="user.nickname">
            </el-table-column>
        </el-table>
        <el-pagination
            v-show="list.pages.pageCount > 1"
            layout="prev, pager, next"
            :page-size="list.pages.perpage"
            :page-count="list.pages.pageCount"
            :current-page="list.pages.page"
            :total="list.pages.totalCount"
            @current-change="goPage"
        >
        </el-pagination>
    </div>
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
            return this.$store.state.admin.allSchedule;
        }
    },
    watch: {
        list() {
            window.scrollTo(0, 0);
        }
    },
    created() {
        this.refreshList();
    },
    methods: {
        refreshList() {
            this.$store.dispatch('admin.allSchedule.list.fetch', {
                page: this.page,
                tid: this.$route.params.tid
            });
        },
        goPage(page) {
            this.page = page;
            this.refreshList();
        },
        showDetail(model) {
            this.$alert(model, '执行结果', {
                confirmButtonText: '确定'
            });
        }
    }
};
</script>