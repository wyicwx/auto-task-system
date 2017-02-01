'use strict';

import { pick } from 'lodash';
import { get, post } from '../helper/api.js';

module.exports = {
    state: {
        'id': '',
        'frequency': 1,
        'data': {},
        'remark': ''
    },
    mutations: {
        'task.set': function(state, data) {
            state.id = data.id;
            state.frequency = data.frequency;
            state.data = JSON.parse(data.data);
            state.remark = data.remark;
        }
    },
    actions: {
        'task.create': function(context, params = {}) {
            var keys = [
                'mid',
                'frequency',
                'data',
                'remark'
            ];

            var data = pick(params, keys);

            return post('/task/create', data);
        },
        'task.update': function(context, params = {}) {
            var keys = [
                'id',
                'frequency',
                'data',
                'remark'
            ];

            var data = pick(params, keys);

            return post('/task/update', data);
        },
        'task.fetch': function(context, params = {}) {
            var keys = [
                'id'
            ];

            var data = pick(params, keys);

            return get('/task/view', data).then((data) => {
                context.commit('task.set', data);
                return data;
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
        }
    }
};