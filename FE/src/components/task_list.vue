<template>
<div>
    <el-table v-loading.body="taskList.loading" :data="taskList.list" style="width: 100%">
        <el-table-column label="代码模板">
            <template scope="scope">
                <router-link :to="'/model/view/'+scope.row.id">{{scope.row.model.name}}</router-link>
            </template>
        </el-table-column>
        <el-table-column label="状态" width="180">
            <template scope="scope">
                <el-tag :close-transition="true" type="gray" v-if="scope.row.status == 1">暂停</el-tag>
                <el-tag :close-transition="true" type="success" v-if="scope.row.status == 0">运行</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="remark" :formatter="retainFormatter" label="备注"></el-table-column>
        <el-table-column prop="times" :formatter="retainFormatter" label="运行次数"></el-table-column>
        <el-table-column label="操作">
            <template scope="scope">
            <el-button
              @click.native.prevent="pauseTask(scope.row.id)"
              type="text"
              size="small">
              暂停
            </el-button>

            <el-button
              @click.native.prevent=""
              type="text"
              size="small">
              编辑
            </el-button>

            <el-button
              @click.native.prevent=""
              type="text"
              size="small">
              删除
            </el-button>

            <el-button
              @click.native.prevent=""
              type="text"
              size="small">
              运行状态
            </el-button>

            
          </template>
        </el-table-column>
    </el-table>
    <el-pagination
        v-show="taskList.pages.pageCount > 1"
        layout="prev, pager, next"
        :page-size="taskList.pages.perpage"
        :page-count="taskList.pages.pageCount"
        :current-page="taskList.pages.page"
        :total="taskList.pages.totalCount"
        @current-change="goPage"
    >
    </el-pagination>
</div>
</template>

<script type="text/javascript">
'use strict';

var {mapState, mapGetters} = require('vuex');

module.exports = {
    computed: {
        taskList() {
            return this.$store.state.taskList;
        }
    },
    mounted() {
        this.$store.dispatch('task.list.fetch');
    },
    methods: {
        // 格式化保留字符
        retainFormatter(item, col) {
            if(item[col.property]) {
                return item[col.property];
            } else {
                return '--';
            }
        },
        goPage(page) {
            this.$store.dispatch('task.list.fetch', {
                page: page
            });
        },
        pauseTask(id) {
            this.$confirm('是否暂停该任务?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

            });
        }
    }
};
</script>