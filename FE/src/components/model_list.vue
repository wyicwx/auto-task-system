<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>控制台</el-breadcrumb-item>
        <el-breadcrumb-item>我的模板</el-breadcrumb-item>
    </el-breadcrumb>
    <div class="mb20 clearfix">
        <router-link to="/model/model" class="f_right">
            <el-button type="primary">
            创建模板
            </el-button>
        </el-button>
    </div>

    <el-table v-loading.body="modelList.loading" :data="modelList.list" style="width: 100%">
        <el-table-column prop="name" label="名称">
            <template scope="scope">
                <router-link :to="'/model/view/'+scope.row.id" target="_blank">{{scope.row.name}}</router-link>
            </template>
        </el-table-column>
        <el-table-column prop="status" :formatter="statusFormatter" label="是否公开" width="100"></el-table-column>
        <el-table-column prop="update_time" label="更新时间" width="180"></el-table-column>
        <el-table-column label="操作" width="180">
            <template scope="scope">
            
            <el-button
              @click.native.prevent="jump('/task/create/'+scope.row.id)"
              type="text"
              size="small">
              创建任务
            </el-button>

            <el-button
              @click.native.prevent="jump('/model/model/'+scope.row.id)"
              type="text"
              size="small">
              编辑
            </el-button>

            <el-button
              @click.native.prevent="deleteModel(scope.row.id)"
              type="text"
              size="small">
              删除
            </el-button>
            
          </template>
        </el-table-column>
    </el-table>
    <el-pagination
        v-show="modelList.pages.pageCount > 1"
        layout="prev, pager, next"
        :page-size="modelList.pages.perpage"
        :page-count="modelList.pages.pageCount"
        :current-page="modelList.pages.page"
        :total="modelList.pages.totalCount"
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
        };
    },
    computed: {
        modelList() {
            return this.$store.state.modelList;
        }
    },
    created() {
        this.$store.commit('model.list.reset');
        this.refreshList();
    },
    methods: {
        refreshList() {
            this.$store.dispatch('model.list.fetch', {
                page: this.page
            });
        },
        goPage(page) {
            this.page = page;
            this.refreshList();
        },
        jump(url) {
            this.$router.push(url);
        },
        statusFormatter(item, col) {
            if(item.status == 0) {
                return '私有';
            } else if(item.status == 1) {
                return '公开';
            }
        },
        deleteModel(id) {
            this.$confirm('此操作将永久删除该模板, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                return this.$store.dispatch('model.delete', {
                    id
                });
            }).then(() => {
                return this.$store.dispatch('model.list.fetch');
            }).catch(() => {});
        }
    }
};
</script>