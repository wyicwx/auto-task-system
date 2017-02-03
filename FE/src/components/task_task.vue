<template>
<div v-loading="model.loading || task.loading" style="height: 100%">
    <div v-if="!model.loading && !task.loading">
        <el-breadcrumb separator="/" class="mb20">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>控制台</el-breadcrumb-item>
            <el-breadcrumb-item v-if="type == 'new'">创建任务</el-breadcrumb-item>
            <el-breadcrumb-item v-if="type == 'edit'">编辑任务</el-breadcrumb-item>
        </el-breadcrumb>
        <el-form ref="form" :model="model" label-width="80px">
            <el-row>
                <el-col :span="12">
                    <el-form-item label="模板名称">
                        <el-input v-model="model.name" readonly></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="18">
                    <el-form-item label="描述">
                        <el-input type="textarea" autosize v-model="model.description" readonly></el-input>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span="12">
                    <el-form-item label="执行频率">
                        <el-select v-model="task.frequency">
                            <el-option value="1">1</el-option>
                            <el-option value="2">2</el-option>
                            <el-option value="3">3</el-option>
                            <el-option value="4">4</el-option>
                            <el-option value="6">6</el-option>
                            <el-option value="8">8</el-option>
                            <el-option value="12">12</el-option>
                            <el-option value="24">24</el-option>
                        </el-select>
                        次/天
                    </el-options>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span="12">
                    <el-form-item label="是否重试" >
                        <el-switch
                          v-model="enableRetry"
                          on-color="#13ce66"
                          off-color="#ff4949">
                        </el-switch>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span="12" v-if="enableRetry">
                    <el-form-item label="重试次数">
                        <el-select v-model="task.retry">
                            <el-option value="0">0</el-option>
                            <el-option value="1">1</el-option>
                            <el-option value="2">2</el-option>
                            <el-option value="3">3</el-option>
                            <el-option value="4">4</el-option>
                            <el-option value="5">5</el-option>
                            <el-option value="6">6</el-option>
                            <el-option value="7">7</el-option>
                            <el-option value="8">8</el-option>
                            <el-option value="9">9</el-option>
                            <el-option value="10">10</el-option>
                        </el-select><br>
                        <el-tag type="warning" :close-transition="true">重试将在失败后半小时执行</el-tag>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span="12">
                    <el-form-item label="运行数据">
                        <el-input class="mb10" placeholder="请输入数据" v-model="task.data[item.name]" v-for="(item, index) in model.datatype">
                            <template slot="prepend">{{item.name}}</template>
                        </el-input>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span="12">
                    <el-form-item label="备注">
                        <el-input type="textarea" v-model="task.remark" placeholder="请输入备注"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-form-item>
                <el-button type="success" @click="save">保存</el-button>
            </el-form-item>
        </el-form>
    </div>
</div>
</template>

<script type="text/javascript">
'use strict';

var _ = require('lodash');

module.exports = {
    data() {
        return {
            type: 'new',
            task: this.$store.state.task,
            enableRetry: false
        }
    },
    computed: {
        model() {
            return this.$store.state.model;
        }
    },
    watch: {
        enableRetry(enable) {
            if(!enable) {
                this.task.retry = 0;
            }
        }
    },
    created() {
        this.$store.commit('task.reset');
        this.$store.commit('model.reset');

        if(this.$route.params.mid) {
            this.type = 'new';

            this.$store.dispatch('model.fetch', {
                id: this.$route.params.mid
            });
        }
        if(this.$route.params.id) {
            this.type = 'edit';

            this.$store.dispatch('task.fetch', {
                id: this.$route.params.id
            }).then((data) => {
                if(data.retry > 0) {
                    this.enableRetry = true;
                }
                this.$store.dispatch('model.fetch', {
                    id: data.mid
                });
            });
        }
    },
    methods: {
        save() {
            if(this.enableRetry && this.task.retry <= 0) {
                return this.$message({
                    message: '请选择重试次数！',
                    type: 'warning'
                });
            }
            if(this.type == 'edit') {
                this.$store.dispatch('task.update', this.task);
            } else {
                this.$store.dispatch('task.create', _.extend({
                    mid: this.model.id
                }, this.task)).then(({id}) => {
                    this.$router.push(`/task/list`);
                });
            }
        }
    }
};
</script>