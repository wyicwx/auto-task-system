<template>
<div class="w_codemirror">
    <textarea ref="textarea" :value="value"></textarea>
</div>
</template>

<script type="text/javascript">
'use strict';

const CodeMirror = require('../../vendors/codemirror/lib/codemirror.js');

require("../../vendors/codemirror/mode/clike/clike.js");
require("../../vendors/codemirror/mode/php/php.js");
require("../../vendors/codemirror/addon/edit/matchbrackets.js");
require('../../vendors/codemirror/codemirror.css');


module.exports = {
    props: {
        value: String
    },
    mounted() {
        CodeMirror.fromTextArea(this.$refs.textarea, {
            mode: 'text/x-php',
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: false,
            matchBrackets: true,
            viewportMargin: Infinity,
            lineWrapping: true
        });
    },
    methods: {
        change() {
            debugger;
        }
    }
}
</script>