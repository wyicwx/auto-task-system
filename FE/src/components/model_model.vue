<template>
<div v-loading="model.loading" element-loading-text="拼命加载中">
    <el-breadcrumb separator="/" class="mb20">
        <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item :to="{ path: '/model/list'}">我的模板</el-breadcrumb-item>
        <el-breadcrumb-item v-if="type == 'new'">创建模板</el-breadcrumb-item>
        <el-breadcrumb-item v-if="type == 'edit'">编辑模板</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form ref="form" :model="model" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="模板名称">
                    <el-input v-model="model.name" placeholder="请输入模板名称"></el-input>
                </el-form-item>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="12">
                <el-form-item label="描述">
                    <el-input type="textarea" autosize v-model="model.description" placeholder="请输入描述内容"></el-input>
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

            <code-mirror v-model="model.code"></code-mirror>
        </el-form-item>

        <el-form-item label="数据类型">
            <el-row v-for="(item, index) in model.datatype">
                <el-col :span="12">
                    <el-input class="mb10" placeholder="请添加数据类型" v-model="item.name" :disabled="type == 'edit'">
                        <el-select slot="prepend" v-model="item.type" placeholder="请选择" :disabled="type == 'edit'">
                            <el-option label="String" value="string"></el-option>
                            <el-option label="Number" value="number"></el-option>
                        </el-select>
                    </el-input>
                </el-col>
                <el-col :span="12" class="pl10" v-if="type == 'new'">
                    <el-button type="" @click="addDataType(index)" icon="plus"></el-button>
                    <el-button type="" v-if="model.datatype.length > 1" @click="removeDataType(index)" icon="minus"></el-button>
                </el-col>
            </el-row>
        </el-form-item>

        <el-form-item>
            <el-button type="success" @click="save">保存</el-button>
            <el-button type="info" @click="checkSyntax">语法检查</el-button>
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
    data() {
        return {
            type: 'new'
        }
    },
    computed: {
        model() {
            return this.$store.state.model;
        }
    },
    mounted() {
        this.init();
    },
    beforeRouteUpdate() {
        this.init();
    },
    methods: {
        init() {
            if(this.$route.params.id) {
                this.type = 'edit';
                this.$store.dispatch('model.fetch', {
                    id: this.$route.params.id
                });
            } else {
                this.type = 'new';
                this.$store.commit('model.reset');
            }
        },
        addDataType(index) {
            this.$store.commit('model.addDataType', index);
        },
        removeDataType(index) {
            this.$store.commit('model.removeDataType', index);
        },
        save() {
            if(this.type == 'edit') {
                this.$store.dispatch('model.update', this.model);
            } else {
                this.$store.dispatch('model.create', this.model).then(({id}) => {
                    this.$router.push(`/model/model/${id}`);
                });
            }
        },
        checkSyntax() {
            this.$store.dispatch('model.code.checksyntax', {
                code: this.model.code
            });
        }
    }
};
</script>