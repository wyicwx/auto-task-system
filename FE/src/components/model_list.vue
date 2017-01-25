<template>
<div>
    <div class="mb20 clearfix">
        <router-link to="/model/model" class="f_right">
            <solt>
                <el-button type="primary">
                创建模板
                </el-button>
            </solt>
        </el-button>
    </div>

    <el-table v-loading.body="modelList.loading" :data="modelList.list" style="width: 100%">
        <el-table-column prop="name" label="名称"></el-table-column>
        <el-table-column prop="status" :formatter="statusFormatter" label="是否公开" width="100"></el-table-column>
        <el-table-column prop="update_time" label="更新时间" width="180"></el-table-column>
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
    computed: {
        modelList() {
            return this.$store.state.modelList;
        }
    },
    mounted() {
        this.$store.dispatch('model.list.fetch');
    },
    methods: {
        goPage(page) {
            this.$store.dispatch('model.list.fetch', {
                page
            });
        },
        statusFormatter(item, col) {
            if(item.status == 0) {
                return '私有';
            } else if(item.status == 1) {
                return '公开';
            }
        }
    }
};
</script>