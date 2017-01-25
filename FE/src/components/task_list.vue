<template>
<div>
    <el-table v-loading.body="loading" :data="tableData" style="width: 100%">
        <el-table-column prop="model.name" label="代码模板" width="180"></el-table-column>
        <el-table-column prop="status" label="状态" width="180">
            
        </el-table-column>
        <el-table-column prop="remark" label="备注"></el-table-column>
        <el-table-column prop="times" label="运行次数"></el-table-column>
        <el-table-column prop="address" label="操作">
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
    <el-pagination v-show="!loading"
        layout="prev, pager, next"
        :total="50">
    </el-pagination>
</div>
</template>

<script type="text/javascript">
module.exports = {
    data() {
        return {
            loading: true,
            tableData: []
        };
    },
    mounted() {
        debugger;
        setTimeout(() => {
            this.loading = false;
        }, 1000);
    }
};
</script>