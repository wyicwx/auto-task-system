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
        value: String,
        readonly: Boolean
    },
    watch: {
        value() {
            var value = this.cm.getValue();

            if(value != this.value) {
                this.cm.setValue(this.value);
            }
        }
    },
    mounted() {
        this.cm = CodeMirror.fromTextArea(this.$refs.textarea, {
            mode: 'text/x-php',
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: false,
            matchBrackets: true,
            viewportMargin: Infinity,
            lineWrapping: true,
            readOnly: this.readonly
        });
        this.cm.on('change', () => {
            this.$emit('input', this.cm.getValue());
        });
    }
}
</script>