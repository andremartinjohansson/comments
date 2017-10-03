Anax comments
==================================

Anax module for system for comments

Installation
------------------

### Install with composer

```
composer require andymartinj/comments
```

### Copy view files

```
rsync -av -vendor/anax/comments/view/comments* view
```

The edit_comment.php view is necessary for editing comments. The comments.php is just for showing how you can add the comment section to a page.

### Router files

```
rsync -av vendor/anax/comments/config/route/comments.php config/route
```

You need to include the router file in your router configuration `config/route.php`. There is a sample you can use in `vendor/anax/comments/config/route.php`.

### DI services

You need to add the services di configuration `config/di.php`. There is a sample you can use in `vendor/anax/comments/config/di.php`.

### Database

The system uses a database to store comments. There is a sample you can use in `vendor/anax/comments/data/comments.sqlite`.

License
------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2017 Andre Johansson (anjd16@student.bth.se)
```
