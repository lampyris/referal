Referral
=======

##Installation

1. git clone https://github.com/lampyris/referal.git
2. composer update --prefer-dist
3. init
5. Create a new database and adjust the components['db'] configuration in common/config/main-local.php accordingly.
6. yii migrate
7. yii migrate --migrationPath=@yii/rbac/migrations
8. yii rbac/init

##Default accounts:

####Administrator
- login: administrator
- password: administrator

####User
- login: user
- password: user
