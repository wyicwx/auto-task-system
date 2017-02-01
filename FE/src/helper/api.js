'use strict';

import { each } from 'lodash';
import { Message } from 'element-ui';

var csrf = 'd1pENThvMmoDIwlXeyRnCRUWLXd3AkgmMmoHf2JeY1wvDQpDVQdnOg==';
var csrfParam = '_csrf-frontend';

function parseBody(body) {
    var result = [];

    each(body, function(value, key) {
        result.push([key, value].join('='));
    });

    return result.join('&');
}

function parseForm(body) {
    var form = new FormData();

    each(body, function(value, key) {
        form.append(key, value); 
    });

    return form;
}

module.exports = {
    get: function(url, body = {}, headers, globMessage = false) {
        body[csrfParam] = csrf;

        if(url.indexOf('?') === -1) {
            url += '?';
        }

        url += parseBody(body);

        return fetch(url, {
            method: 'get',
            headers: headers,
            credentials: 'include'
        }).then((res) => {
            if(res.ok) {
                return res.json();
            } else {
                return Promise.reject({
                    msg: '解析数据错误！请重试！'
                });
            }
        }).then((data) => {
            if(data.code === 0) {

                if(globMessage) {
                    Message.success({
                        message: data.msg,
                        duration: 2000,
                        showClose: true
                    })
                }

                return data.data;
            } else {
                return Promise.reject(data);
            }
        }).catch((data) => {
            if(data && data.msg) {
                Message.error({
                    message: data.msg,
                    duration: 2000,
                    showClose: true
                });
            } else {
                Message.error({
                    message: '系统错误！请重试！',
                    duration: 2000,
                    showClose: true
                });
            }

            return Promise.reject(data);
        });
    },
    post: function(url, body = {}, headers = {}, globMessage = true) {
        body[csrfParam] = csrf;

        headers['Content-Type'] = 'application/json';

        return fetch(url, {
            method: 'post',
            headers: headers,
            credentials: 'include',
            body: JSON.stringify(body)
        }).then((res) => {
            if(res.ok) {
                return res.json();
            } else {
                return Promise.reject({
                    msg: '解析数据错误！请重试！'
                });
            }
        }).then((data) => {
            if(data.code === 0) {
                if(globMessage) {
                    Message.success({
                        message: data.msg,
                        duration: 2000,
                        showClose: true
                    });
                }

                return data.data;
            } else {
                return Promise.reject(data);
            }
        }).catch((data) => {
            if(globMessage) {
                if(data && data.msg) {
                    var msg = [];

                    if(data.code === 2) { // 表单填写错误
                        msg = [];

                        each(data.data, (item, key) => {
                            msg.push(item.join(''));
                        });
                    } else {
                        msg.push(data.msg);
                    }

                    Message.error({
                        message: msg.join(''),
                        duration: 2000,
                        showClose: true
                    });
                } else {
                    Message.error({
                        message: '系统错误！请重试！',
                        duration: 2000,
                        showClose: true
                    });
                }
            }

            return Promise.reject(data);
        });
    }
};