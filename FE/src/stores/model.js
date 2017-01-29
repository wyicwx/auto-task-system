'use strict';

import lodash from 'lodash';
import {get, post} from '../helper/api.js';

module.exports = {
    state: {
        name: '',
        description: '',
        code: '',
        datatype: [{
            value: '',
            select: 'string'
        }],
        loading: false
    },
    mutations: {
        'model.addDataType': function(state, index) {
            state.datatype.splice(index + 1, 0, {
                select: 'string',
                value: ''
            });
        },
        'model.removeDataType': function(state, index) {
            state.datatype.splice(index, 1);
        },
        'model.setModel': function(state, data) {
            state.name = data.name;
            state.code = data.code;
            state.description = data.description;
            state.datatype = JSON.parse(data.datatype);
        },
        'model.reset': function(state) {
            state.name = '';
            state.description = '';
            state.code = '';
            state.datatype = [{
                value: '',
                select: 'string'
            }];
        }
    },
    actions: {
        'model.fetch': function(context, params = {}) {
            return get('/model/view', {
                id: params.id
            }).then((data) => {
                context.commit('model.setModel', data);
            });
        },
        'model.create': function(context, params) {
            var keys = [
                'name',
                'code',
                'description',
                'datatype'
            ];

            var data = _.pick(params, keys);

            return post('/model/create', data);
        },
        'model.update': function(context, params) {
            var keys = [
                'name',
                'code',
                'description',
                'datatype'
            ];

            var data = _.pick(params, keys);

            debugger;
            // data.datatype = JSON.stringify(data.datatype);

            return post('/model/update', data);
        }
    }
};