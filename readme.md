1) Authorization makes by http request:
    http://94.103.91.70/api/user/login
    http-request-type: POST
    parametrs: 
        email:amindiyass@gmail.com
        password:helloWorld
    response:
        user data and access_token
        
2) Purchase makes by http request:
    http://94.103.91.70/api/user/products/buy
    http-request-type: POST
    headers: 
        Authorization: Bearer  {token}
        Content-Type: application/json
        Accept: application/json
    parametrs:
        product_id (product_id less than 100 and more than 0), 
        quantity
    response:
        message about your purchse status,
        data that stores in redis (cron job runs every 1 minute for run 'transfer:fromTempToDB' command that transfer data to db)
        
 3) See own products makes by http request:
    http://94.103.91.70/api/user/products/
    http-request-type: GET
    headers: 
        Authorization: Bearer  {token}
        Content-Type: application/json
        Accept: application/json
    parametrs: no
    
 4) See own payment history makes by http request:
    http://94.103.91.70/api/user/products/payment-history
    http-request-type: GET
    headers: 
        Authorization: Bearer  {token}
        Content-Type: application/json
        Accept: application/json
    parametrs: no
    
 
        
        
