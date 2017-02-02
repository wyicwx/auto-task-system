'use strict';

import { get, post } from '../helper/api.js';

module.exports = {
    state: {
        fetchLoading: false,
        enableCodeFunc: []
    },
    modules: {
        user: require('./user.js'),
        task: require('./task.js'),
        taskList: require('./task_list.js'),
        modelList: require('./model_list.js'),
        model: require('./model.js'),
        statisticsTaskList: require('./statistics_task_list.js'),
        admin: require('./admin.js')
    },
    actions: {
        'logout': function() {
            return post('/site/logout');
        },
        'enableCodeFuncFetch': function(context) {
            if(context.state.enableCodeFunc.length) {
                return Promise.resolve(context.state.enableCodeFunc);
            }

            return get('/model/sandboxenablefunc').then((data) => {
                context.commit('setEnableCodeFunc', data);
                return data;
            });
        }
    },
    mutations: {
        'setEnableCodeFunc': function(state, data) {
            state.enableCodeFunc = data;
        }
    }
};