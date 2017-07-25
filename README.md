Alfa-Spa on Yii 2 Basic
============================

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.

Deploy via lftp
---------------

Edit `/.gitlab-ci.yml` file content to:

```
deploy:   
    script:     
        - apt-get update -qq && apt-get install -y -qq lftp     
        - lftp -c "set ftp:ssl-allow no; open -u $USERNAME,$PASSWORD $HOST; mirror -Rev --ignore-time --parallel=10 --exclude-glob .git* --exclude .git/ --exclude vendor/ --exclude web/images/ --exclude config/db.php"   
    only:     
        - master
```

Deploy via git-ftp
---------------

Edit `/.gitlab-ci.yml` file content to:
### After first successful deploy change `init` to `push`
```
image: samueldebruyn/debian-git 
deploy:   
    script:     
        - apt-get update     
        - apt-get -qq install git-ftp     
        - git ftp init --user $USERNAME --passwd $PASSWORD $HOST   
    only:     
        - master
```