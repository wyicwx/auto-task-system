'use strict';

import { pick } from 'lodash';
import { get, post } from '../helper/api.js';

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
            state.loading = false;
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
        'model.loading': function(state) {
            state.loading = true;
        },
        'model.loading.false': function(state) {
            state.loading = false;
        }
    },
    actions: {
        'model.fetch': function(context, params = {}) {
            context.commit('model.loading');

            return get('/model/view', {
                id: params.id
            }, false, false, false).then((data) => {
                context.commit('model.setModel', data);
            }).then(() => {
                context.commit('model.loading.false');
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
        },
        'model.debug.run': function(context, params) {
            var keys = [
                'model',
                'data'
            ];

            var data = pick(params, keys);

            return post('/model/debug', data);
        }
    }
};