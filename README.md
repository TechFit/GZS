WORKFLOW

1. api.your-domain/v1/user/add
2. php yii redis:transfer-to-mysql
3. your-domain/index

1.1 For saving data about user

   POST param: data, structure {'firstName':'Name', 'lastName':'Name', 'phoneNumbers
   :''}
   
2.1 Table with users and search

   
3.1 Command for transfer data between Redis and Mysql, for example set command to Cron
   