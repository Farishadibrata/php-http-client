# PHP HTTP client to express

## Install

1. cd nodejs_JWT
2. npm install 
3. node index.js

## Routes

### PHP

1. POST : /login 

   Get token from /login on Express

2. POST : /protected

   To test validity of token and execute protected function

### Express

1. GET : /

   It does nothing

2. POST : /login

   Get JWT, default login : (username = admin, password = admin111)

3. POST : /checkjwt

   to check validity of JWT token