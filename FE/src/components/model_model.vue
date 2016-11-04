<template>
<div>
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item :to="{ path: '/model/list'}">我的模板</el-breadcrumb-item>
        <el-breadcrumb-item>创建模板</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form ref="form" :model="form" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="模板名称">
                    <el-input v-model="form.name" placeholder="请输入模板名称"></el-input>
                </el-form-item>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="12">
                <el-form-item label="描述">
                    <el-input type="textarea" v-model="form.description" placeholder="请输入描述内容"></el-input>
                </el-form-item>
            </el-col>
        </el-row>
        <el-form-item label="代码">
            <ol class="w_alert_warning" style="padding-left: 35px;">
                <li>
                    允许使用函数：json_encode、json_decode、rand
                </li>
                <li>
                    提供 <a href="https://github.com/rmccue/Requests" target="_blank">Requests</a> 对象，发起http请求，<a href="http://requests.ryanmccue.info/api/class-Requests.html">文档地址</a>
                </li>
                <li>
                    数据类型可以直接作为变量使用，如定义了名为cookie的数据类型，可直接在代码中使用 $cookie
                </li>
            </ol>

            <code-mirror v-model="form.code"></code-mirror>
        </el-form-item>

        <el-form-item label="数据类型">
            <el-row v-for="(item, index) in datatype">
                <el-col :span="12">
                    <el-input class="mb10" placeholder="请添加数据类型" v-model="item.value">
                        <el-select slot="prepend" v-model="item.select" placeholder="请选择">
                            <el-option label="String" value="string"></el-option>
                            <el-option label="Number" value="number"></el-option>
                        </el-select>
                    </el-input>
                </el-col>
                <el-col :span="12" class="pl10">
                    <el-button type="" @click="addDataType(index)" icon="plus"></el-button>
                    <el-button type="" v-if="datatype.length > 1" @click="removeDataType(index)" icon="minus"></el-button>
                </el-col>
            </el-row>
        </el-form-item>

        <el-form-item>
            <el-button type="success" @click="save">保存</el-button>
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
    watch: {
        form() {
            console.log(arguments);
        }
    },
    data() {
        return {
            form: {
                code: 'echo 111;'
            },
            datatype: [{
                select: 'string',
                value: ''
            }]
        }
    },
    methods: {
        addDataType(index) {
            this.datatype.splice(index + 1, 0, {
                select: 'string',
                value: ''
            });
        },
        removeDataType(index) {
            this.datatype.splice(index, 1);
        },
        select(index) {
        },
        save() {
            debugger;
        }
    }
};
</script>