<template>
<div v-loading="marketList.loading" style="height: 100%;">
    <div v-if="!marketList.loading">    
        <el-breadcrumb separator="/" class="mb20">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>控制台</el-breadcrumb-item>
            <el-breadcrumb-item>公开模板</el-breadcrumb-item>
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

                            <div style="font-size: 16px;">
                                <router-link :to="'/model/view/'+item.id" target="_blank">{{item.name}}</router-link>
                            </div>
                            <div style="margin-bottom: -10px;">
                                成功率：
                                <el-tag :close-transition="true" v-if="item.times.ratio >= 60" type="success">{{item.times.ratio}}%</el-tag>
                                <el-tag :close-transition="true" v-if="item.times.ratio >= 30 && item.times.ratio < 60" type="warning">{{item.times.ratio}}%</el-tag>
                                <el-tag :close-transition="true" v-if="item.times.ratio < 30" type="danger">{{item.times.ratio}}%</el-tag>，

                                运行次数：{{parseInt(item.times.negative)+parseInt(item.times.positive)}}次
                            </div>
                        </div>
                        <div class="tx_unbr3" style="height: 4.5em;line-height: 1.5;">
                            <router-link :to="'/model/view/'+item.id" target="_blank" style="color:#aaa;">
                                {{item.description}}
                            </router-link>
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