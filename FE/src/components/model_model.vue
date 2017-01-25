<template>
<div>
    <el-form ref="form" :model="form" label-width="80px">
        <el-form-item label="模板名称">
            <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="描述">
            <el-input type="textarea" v-model="form.description"></el-input>
        </el-form-item>
        <el-form-item label="代码">
            
        </el-form-item>
    </el-form>
</div>
</template>

<script type="text/javascript">
'use strict';

module.exports = {
    data() {
        return {
            form: {}
        }
    }
};
</script>