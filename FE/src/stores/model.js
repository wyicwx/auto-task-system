'use strict';

import lodash from 'lodash';
import {get, post} from '../helper/api.js';

module.exports = {
    state: {
        id: '',
        name: '',
        description: '',
        code: '',
        datatype: [{
            name: '',
            type: 'string'
        }],
        user: '',
        loading: false
    },
    mutations: {
        'model.addDataType': function(state, index) {
            state.datatype.splice(index + 1, 0, {
                type: 'string',
                name: ''
            });
        },
        'model.removeDataType': function(state, index) {
            state.datatype.splice(index, 1);
        },
        'model.setModel': function(state, data) {
            state.id = data.id;
            state.name = data.name;
            state.code = data.code;
            state.description = data.description;
            state.datatype = JSON.parse(data.datatype);
            state.user = data.user;
        },
        'model.reset': function(state) {
            state.id = '';
            state.name = '';
            state.description = '';
            state.code = '';
            state.datatype = [{
                name: '',
                type: 'string'
            }];
            state.user = {};
            state.loading = false;
        },
        'model.saving': function(state) {
            state.saving = true;
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
                'id',
                'name',
                'code',
                'description',
                'datatype'
            ];

            var data = _.pick(params, keys);

            return post('/model/update', data);
        },
        'model.delete': function(context, params) {
            var keys = [
                'id'
            ];

            var data = _.pick(params, keys);

            return post('/model/delete', data);
        },
        'model.publish': function(context, params) {
            var keys = [
                'id'
            ];

            var data = _.pick(params, keys);

            return post('/model/publish', data);
        },
        'model.private': function(context, params) {
            var keys = [
                'id'
            ];

            var data = _.pick(params, keys);

            return post('/model/private', data);
        },
        'model.code.checksyntax': function(context, params) {
            var keys = [
                'code'
            ];

            var data = _.pick(params, keys);

            return post('/model/checksyntax', data);
        }
    }
};