Anax comments
==================================

[![Latest Stable Version](https://poser.pugx.org/anax/comments/v/stable)](https://packagist.org/packages/anax/comments)
[![Join the chat at https://gitter.im/mosbth/anax](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/canax?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/canax/comments.svg?branch=master)](https://travis-ci.org/canax/comments)
[![CircleCI](https://circleci.com/gh/canax/comments.svg?style=svg)](https://circleci.com/gh/canax/comments)
[![Build Status](https://scrutinizer-ci.com/g/canax/comments/badges/build.png?b=master)](https://scrutinizer-ci.com/g/canax/comments/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/canax/comments/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/canax/comments/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/canax/comments/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/canax/comments/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929/mini.png)](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929)

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
