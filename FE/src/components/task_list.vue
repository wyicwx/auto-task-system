<template>
<div>
    <el-table v-loading.body="taskList.loading" :data="taskList.list" style="width: 100%">
        <el-table-column prop="model.name" label="代码模板" width="180"></el-table-column>
        <el-table-column prop="status" :formatter="statusFormatter" label="状态" width="180">
            
        </el-table-column>
        <el-table-column prop="remark" :formatter="retainFormatter" label="备注"></el-table-column>
        <el-table-column prop="times" :formatter="retainFormatter" label="运行次数"></el-table-column>
        <el-table-column label="操作">
            <template scope="scope">
            <el-button
              @click.native.prevent=""
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
    <el-pagination v-show="!taskList.loading"
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
        // 格式化状态
        statusFormatter(item) {
            if(item.status == 1) {
                return '运行';
            } else if(item.status == 0) {
                return '暂停';
            }
        },
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
        }
    }
};
</script>