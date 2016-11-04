<template>
<div v-loading="model.loading" element-loading-text="拼命加载中">
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item :to="{ path: '/model/list'}">我的模板</el-breadcrumb-item>
        <el-breadcrumb-item>查看模板</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form ref="form" :model="model" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="模板名称">
                    {{model.name}}
                </el-form-item>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="12">
                <el-form-item label="描述">
                    {{model.description}}
                </el-form-item>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="12">
                <el-form-item label="维护者">
                    {{model.user.nickname}}
                </el-form-item>
            </el-col>
        </el-row>
        <el-form-item label="代码">
            <code-mirror v-model="model.code" readonly></code-mirror>
        </el-form-item>

        <el-form-item label="数据类型">
            <el-row v-for="(item, index) in model.datatype">
                <el-col :span="12">
                    <el-input class="mb10" placeholder="请添加数据类型" v-model="item.name" readonly>
                        <el-select slot="prepend" v-model="item.type" placeholder="请选择" disabled>
                            <el-option label="String" value="string"></el-option>
                            <el-option label="Number" value="number"></el-option>
                        </el-select>
                    </el-input>
                </el-col>
            </el-row>
        </el-form-item>
    </el-form>
</div>
</template>
<style type="text/css">
.el-input-group__prepend .el-select .el-input input {
    width: 100px;
}
</style>
<script type="text/javascript">
'use strict';

var CodeMirror = require('./widget/codemirror.vue');

module.exports = {
    components: {
        'code-mirror': CodeMirror
    },
    computed: {
        model() {
            return this.$store.state.model;
        }
    },
    created() {
        if(this.$route.params.id) {
            this.type = 'edit';
            this.$store.dispatch('model.fetch', {
                id: this.$route.params.id
            });
        }
    }
};
</script>