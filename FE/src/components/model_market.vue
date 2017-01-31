<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>控制台</el-breadcrumb-item>
        <el-breadcrumb-item>模板商店</el-breadcrumb-item>
    </el-breadcrumb>

    <el-row>
        <el-col class="mb20" :span="8" v-for="(item, index) in marketList.list">
            <div :style="{paddingRight: '0px', paddingLeft: index%3 != 0 ? '10px': '0px'}">
                <el-card >
                    <div slot="header">
                        <div class="mb10" style="line-height: 30px;height: 30px;">
                            <img class="vam" :src="item.user.avatar" style="border-radius: 50%;overflow: hidden;width: 30px;"/>
                            <span class="pl5 pr5">{{item.user.nickname}}</span>
                            <span style="color: gray">提供的模板</span>
                            <router-link :to="'/task/create/'+item.id" class="f_right">
                                <el-button type="info" size="small">创建任务</el-button>
                            </router-link>
                        </div>

                        <div style="font-size: 16px;margin-bottom: -10px;">
                            <router-link :to="'/model/view/'+item.id" target="_blank">{{item.name}}</router-link>
                        </div>
                    </div>
                    <div class="tx_unbr3" style="height: 4.5em;line-height: 1.5;color:#aaa;">
                        {{item.description || '无描述'}}
                    </div>
                </el-card>
            </div>
        </el-col>
    </el-row>

    <el-pagination
        v-show="marketList.pages.pageCount > 1"
        layout="prev, pager, next"
        :page-size="marketList.pages.perpage"
        :page-count="marketList.pages.pageCount"
        :current-page="marketList.pages.page"
        :total="marketList.pages.totalCount"
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
        marketList() {
            return this.$store.state.modelList;
        }
    },
    created() {
        this.$store.commit('model.list.reset');
        this.refreshList();
    },
    methods: {
        refreshList() {
            this.$store.dispatch('model.market.fetch', {
                page: this.page
            });
        },
        goPage(page) {
            this.page = page;
            this.refreshList();
        },
    }
};
</script>