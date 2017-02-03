'use strict';

import { pick } from 'lodash';
import { get, post } from '../helper/api.js';

module.exports = {
    state: {
        'id': '',
        'frequency': 1,
        'data': {},
        'remark': '',
        'loading': false,
        'retry': 0
    },
    mutations: {
        'task.set': function(state, data) {
            state.id = data.id;
            state.frequency = data.frequency;
            state.data = JSON.parse(data.data);
            state.remark = data.remark;
            state.retry = data.retry;
            state.loading = false;
        },
        'task.reset': function(state) {
            state.id = '',
            state.frequency = 1;
            state.data = {};
            state.remark = '';
            state.loading = false;
            state.retry = 0;
        },
        'task.loading': function(state) {
            state.loading = true
        },
        'task.loading.false': function(state) {
            state.loading = false;
        }
    },
    actions: {
        'task.create': function(context, params = {}) {
            var keys = [
                'mid',
                'frequency',
                'data',
                'remark',
                'retry'
            ];

            var data = pick(params, keys);

            return post('/task/create', data);
        },
        'task.update': function(context, params = {}) {
            var keys = [
                'id',
                'frequency',
                'data',
                'remark',
                'retry'
            ];

            var data = pick(params, keys);

            return post('/task/update', data);
        },
        'task.fetch': function(context, params = {}) {
            var keys = [
                'id'
            ];

            var data = pick(params, keys);
            context.commit('task.loading');
            return get('/task/view', data, false, false, false).then((data) => {
                context.commit('task.set', data);
                return data;
            }, () => {
                context.commit('task.loading.false');
            });
        },
        'task.delete': function(context, params = {}) {
            var keys = [
                'id'
            ];

            var data = pick(params, keys);

            return post('/task/delete', data).then(() => {
            });
        },
        'task.pause': function(context, params = {}) {
            var keys = [
                'id'
            ];

            var data = pick(params, keys);

            return post('/task/pause', data).then(() => {
                context.commit('task.list.pause', data.id);
            });
        },
        'task.resume': function(context, params = {}) {
            var keys = [
                'id'
            ];

            var data = pick(params, keys);

            return post('/task/resume', data).then(() => {
                context.commit('task.list.resume', data.id);
            });
        },
        'task.runOne': function(context, params = {}) {
            var keys = [
                'id'
            ];

            var data = pick(params, keys);

            return post('/task/runone', data);
        }
    }
};