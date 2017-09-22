##### Start server 
```
php index.php
```
##### Register event
```
var conn = new WebSocket('127.0.0.1:8080/event');
conn.send('{"event_name": "product_published", "subject_id": 1880, "user": 1}');
```
##### Subscribe user
```
var ws = new WebSocket('ws://127.0.0.1:8000/user');
ws.onmessage = function(e) {console.log(e.data)};
ws.send('{"id": 1}');
```