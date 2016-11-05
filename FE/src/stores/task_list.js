'use strict';

import { get } from '../helper/api';
import _ from 'lodash';

module.exports = {
    state: {
        loading: true,
        list: [],
        pages: {
            page: 1,
            total: 0,
            perpage: 20,
            total: 1
        }
    },
    mutations: {
        'task.list.resume': function(state, id) {
            var item = _.find(state.list, {id: id});

            if(item) {
                item.status = 0;
            }
        },
        'task.list.pause': function(state, id) {
            var item = _.find(state.list, {id: id});

            if(item) {
                item.status = 1;
            }
        },
        'task.list.success': function(state, data) {
            state.loading = false;
            state.list = data.list;
            state.pages = data.pages;
        },
        'task.list.fail': function() {
            state.loading = false;
        },
        'task.list.loading': function(state) {
            state.loading = true;
        }
    },
    actions: {
        'task.list.fetch': function(context, params = {}) {
            context.commit('task.list.loading');

            get('/task/list', {
                page: params.page || 1
            }).then((data) => {
                context.commit('task.list.success', data);
            }, () => {
                context.commit('task.list.fail');
            });
        }
    }
};