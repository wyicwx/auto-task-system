<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>控制台</el-breadcrumb-item>
        <el-breadcrumb-item>我的任务</el-breadcrumb-item>
    </el-breadcrumb>
    <el-table v-loading.body="taskList.loading" :data="taskList.list" style="width: 100%">
        <el-table-column label="代码模板">
            <template scope="scope">
                <router-link :to="'/model/view/'+scope.row.mid" target="_blank">{{scope.row.model.name}}</router-link>
            </template>
        </el-table-column>
        <el-table-column align="center" label="状态" width="180">
            <template scope="scope">
                <el-tag :close-transition="true" type="gray" v-if="scope.row.status == 1">暂停</el-tag>
                <el-tag :close-transition="true" type="success" v-if="scope.row.status == 0">运行</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="remark" :formatter="retainFormatter" label="备注"></el-table-column>
        <!-- <el-table-column align="center" prop="times" :formatter="retainFormatter" label="运行次数" width="100"></el-table-column> -->
        <el-table-column label="操作" width="260">
            <template scope="scope">
                <el-button
                  v-if="scope.row.status == 0"
                  @click.native.prevent="pauseTask(scope.row.id)"
                  type="text"
                  size="small">
                  暂停
                </el-button>

                <el-button
                  v-if="scope.row.status == 1"
                  @click.native.prevent="resumeTask(scope.row.id)"
                  type="text"
                  size="small">
                  继续
                </el-button>

                <el-button
                  @click.native.prevent="jump('/task/task/'+scope.row.id)"
                  type="text"
                  size="small">
                  编辑
                </el-button>

                <el-button
                  @click.native.prevent="deleteTask(scope.row.id)"
                  type="text"
                  size="small">
                  删除
                </el-button>

                <el-button
                  @click.native.prevent="jump('/statistics/task/'+scope.row.id)"
                  type="text"
                  size="small">
                  运行状态
                </el-button>

                <el-button
                  @click.native.prevent="runNow(scope.row.id)"
                  type="text"
                  size="small">
                  单次运行
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
    data() {
        return {
            page: 1
        }
    },
    computed: {
        taskList() {
            return this.$store.state.taskList;
        }
    },
    created() {
        this.refreshList();
    },
    methods: {
        refreshList() {
            return this.$store.dispatch('task.list.fetch', {
                page: this.page
            });
        },
        // 格式化保留字符
        retainFormatter(item, col) {
            if(item[col.property]) {
                return item[col.property];
            } else {
                return '--';
            }
        },
        jump(url) {
            this.$router.push(url);
        },
        goPage(page) {
            this.page = page;
            this.refreshList();
        },
        pauseTask(id) {
            this.$confirm('是否暂停该任务?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                return this.$store.dispatch('task.pause', {
                    id
                });
            });
        },
        deleteTask(id) {
            this.$confirm('此操作将永久删除该任务, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                return this.$store.dispatch('task.delete', {
                    id
                });
            }).then(() => {
                this.refreshList();
            });
        },
        resumeTask(id) {
            this.$confirm('是否继续该任务?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                return this.$store.dispatch('task.resume', {
                    id
                });
            });
        },
        runNow(id) {
            this.$store.dispatch('task.runOne', {
                id
            }).then((data) => {
                 this.$alert(`返回代码: ${data.code}，返回数据：${data.msg}`, '运行结果', {
                    confirmButtonText: '确定'
                });
            });
        }
    }
};
</script>