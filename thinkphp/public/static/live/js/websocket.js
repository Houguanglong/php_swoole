//websocket 地址
var wsUrl = 'ws://47.107.146.132:8887';
//创建websocket对象实例
var websocket = new WebSocket(wsUrl);

//成功和websockte服务建立连接 执行回调函数
websocket.onopen = function (evt) {
    //连接成功 发送数据给服务器
    websocket.send('How are you?');
    console.log('wb_server-connect-success');
}

//接收服务器返回数据
websocket.onmessage = function (evt) {
    console.log('ws_server-return-data:'+evt.data);
}

//连接关闭
websocket.onclose = function (evt) {
    console.log('ws_server-close');
}

//发送错误
websocket.onerror = function (evt,err) {
    console.log('ws_server-error-data:'+err);
}