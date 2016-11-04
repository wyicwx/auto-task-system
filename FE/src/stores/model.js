'use strict';

import {get, post} from '../helper/api.js';

module.exports = {
    state: {
        name: '',
        description: '',
        code: '',
        datatype: [{
            value: '',
            select: 'string'
        }]
    },
    mutations: {

    },
    actions: {
        'model.fetch': function(context) {
            return get('/model/view')
        },
        'model.save': function() {

        }
    }
};