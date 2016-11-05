'use strict';

import { post } from '../helper/api.js';

module.exports = {
    state: {

    },
    modules: {
        user: require('./user.js'),
        task: require('./task.js'),
        taskList: require('./task_list.js'),
        modelList: require('./model_list.js'),
        model: require('./model.js'),
        statisticsTaskList: require('./statistics_task_list.js')
    },
    actions: {
        'logout': function() {
            return post('/');
        }
    }
};