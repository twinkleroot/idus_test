# API 문서
## 회원 가입
### - Request URL
POST http://api.domain.com/api/user/{id}
### - REQUEST Body
```json
{
    "name":"안정모",
    "nickname":"justin",
    "password":"Password1!",
    "email":"twinklehs0212@gmail.com",
    "gender":"male",
    "phone_num":"01090346256"
}
```
### - Success Response Body
```json
{
    "code": 1000,
    "message": "success.",
    "newUserId": 52
}
```
### - Fail Response Body
```json
{
    "code": 2000,
    "message": "fail to join user.",
}
```
## 단일 회원 상세 정보 조회
### - Request URL
GET http://api.domain.com/api/user/{id}
### - Query Parameters
None
### - Success Response Body
```json
{
    "code": 1000,
    "message": "success.",
    "user": {
        "id": 5,
        "name": "안정모",
        "nickname": "justin",
        "phone_num": 01090346256,
        "email": "twinklehs0212@gmail.com",
        "gender": "male"
    }
}
```
### - Fail Response Body
```json
{
    "code": 2000,
    "message": "fail to get user detail.",
}
```
## 단일 회원의 주문 목록 조회
### - Request URL
GET http://api.domain.com/api/user/{id}/orders
### - Query Parameters
None
### - Success Response Body
```json
{
    "code": 1000,
    "message": "success.",
    "orders": [
        {
            "id": 6,
            "order_id": "QWERSD123983",
            "product_name": "포도",
            "price": 30000,
            "created_at": "2021-06-22T20:42:52.000000Z",
            "updated_at": "2021-06-22T20:42:52.000000Z",
            "user_id": 5
        },
        ...
    ]
}
```
### - Fail Response Body
```json
{
    "code": 2000,
    "message": "fail to get orders of user.",
}
```
## 여러 회원 목록 조회
### - Request URL
GET http://api.domain.com/api/user/
### - Query Parameters
- page = 1
- name = 안정모
- email = twinklehs0212@gmail.com
### - Success Response Body
```json
{
    "code": 1000,
    "message": "success.",
    "data": {
        "3_안정모": {
            "id": 3,
            "name": "안정모",
            "nickname": "justin",
            "email": "twinklehs0212@gmail.com",
            "gender": "male",
            "lastOrder": {
                "id": 5,
                "order_id": "ABCDEF123456",
                "product_name": "사과",
                "price": 10000,
                "created_at": "2021-06-22T20:42:52.000000Z",
                "updated_at": "2021-06-22T20:42:52.000000Z",
                "user_id": 3
            }
        },
        ...
    }
}
```
### - Fail Response Body
```json
{
    "code": 2000,
    "message": "fail to get users.",
}
```

## 회원 로그인
### - Request URL
POST http://api.domain.com/api/login
### - REQUEST Body
```json
{
    "email":"twinklehs0212@gmail.com",
    "password":"Password1!"
}
```
### - Success Response Body
```json
{
    "code": 1000,
    "message": "success.",
}
```
### - Fail Response
- Http Response Code : 401
- Body 
```json
{
    "code": 2000,
    "message": "login failed.",
}
```
## 회원 로그아웃
POST http://api.domain.com/api/logout
### - REQUEST Body
None
### - Success Response Body
```json
{
    "code": 1000,
    "message": "success.",
}
```