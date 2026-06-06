<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '/' => 'route0',
      '/topics' => 'route1',
      '/articles' => 'route3',
      '/questions' => 'route5',
      '/users' => 'route8',
      '/notifications' => 'route10',
      '/inbox' => 'route11',
      '/sitemap.xml' => 'route12',
      '/api/stats' => 'route14',
      '/api/options' => 'route16',
      '/api/users' => 'route21',
      '/api/user' => 'route35',
      '/api/user/followers' => 'route44',
      '/api/user/followees' => 'route45',
      '/api/user/following_questions' => 'route46',
      '/api/user/following_articles' => 'route47',
      '/api/user/following_topics' => 'route48',
      '/api/user/questions' => 'route49',
      '/api/user/answers' => 'route50',
      '/api/user/articles' => 'route51',
      '/api/user/comments' => 'route52',
      '/api/topics' => 'route66',
      '/api/questions' => 'route83',
      '/api/answers' => 'route100',
      '/api/articles' => 'route117',
      '/api/comments' => 'route130',
      '/api/reports' => 'route138',
      '/api/notifications/count' => 'route143',
      '/api/notifications' => 'route145',
      '/api/images' => 'route153',
      '/rss/questions' => 'route159',
      '/rss/articles' => 'route161',
      '/admin' => 'route167',
      '/install' => 'route168',
    ),
    'POST' => 
    array (
      '/api/tokens' => 'route15',
      '/api/users' => 'route23',
      '/api/user/avatar' => 'route37',
      '/api/user/cover' => 'route39',
      '/api/user/register/email' => 'route41',
      '/api/user/password/email' => 'route42',
      '/api/topics' => 'route68',
      '/api/questions' => 'route88',
      '/api/articles' => 'route122',
      '/api/notifications/read' => 'route144',
      '/api/captchas' => 'route151',
      '/api/emails' => 'route152',
      '/api/images' => 'route154',
      '/install/import_database' => 'route169',
    ),
    'PATCH' => 
    array (
      '/api/options' => 'route17',
      '/api/user' => 'route36',
    ),
    'DELETE' => 
    array (
      '/api/user/avatar' => 'route38',
      '/api/user/cover' => 'route40',
      '/api/notifications' => 'route146',
    ),
    'PUT' => 
    array (
      '/api/user/password' => 'route43',
    ),
  ),
  1 => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/topics/(\\d+)|/articles/(\\d+)()|/questions/(\\d+)()()|/questions/(\\d+)/answers/(\\d+)()()|/users/(\\d+)()()()()|/api/users/(\\d+)/followers()()()()()|/api/users/(\\d+)()()()()()()|/api/users/(\\d+)/followees()()()()()()()|/api/users/(\\d+)/following_questions()()()()()()()()|/api/users/(\\d+)/following_articles()()()()()()()()()|/api/users/(\\d+)/following_topics()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route2',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          3 => 
          array (
            0 => 'route4',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          4 => 
          array (
            0 => 'route6',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          5 => 
          array (
            0 => 'route7',
            1 => 
            array (
              'question_id' => 'question_id',
              'answer_id' => 'answer_id',
            ),
          ),
          6 => 
          array (
            0 => 'route9',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          7 => 
          array (
            0 => 'route18',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          8 => 
          array (
            0 => 'route22',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          9 => 
          array (
            0 => 'route27',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          10 => 
          array (
            0 => 'route28',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          11 => 
          array (
            0 => 'route29',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          12 => 
          array (
            0 => 'route30',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
        ),
      ),
      1 => 
      array (
        'regex' => '~^(?|/api/users/(\\d+)/questions|/api/users/(\\d+)/answers()|/api/users/(\\d+)/articles()()|/api/users/(\\d+)/comments()()()|/api/topics/(\\d+)/followers()()()()|/api/topics/(\\d+)()()()()()|/api/topics/(\\d+)/questions()()()()()()|/api/topics/(\\d+)/articles()()()()()()()|/api/questions/(\\d+)/comments()()()()()()()()|/api/questions/(\\d+)/followers()()()()()()()()()|/api/questions/(\\d+)()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route31',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          3 => 
          array (
            0 => 'route32',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          4 => 
          array (
            0 => 'route33',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          5 => 
          array (
            0 => 'route34',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          6 => 
          array (
            0 => 'route63',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          7 => 
          array (
            0 => 'route67',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          8 => 
          array (
            0 => 'route70',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          9 => 
          array (
            0 => 'route71',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          10 => 
          array (
            0 => 'route72',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          11 => 
          array (
            0 => 'route80',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          12 => 
          array (
            0 => 'route84',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
        ),
      ),
      2 => 
      array (
        'regex' => '~^(?|/api/questions/(\\d+)/voters|/api/questions/(\\d+)/answers()|/api/answers/(\\d+)/comments()()|/api/answers/(\\d+)()()()|/api/answers/(\\d+)/voters()()()()|/api/articles/(\\d+)/comments()()()()()|/api/articles/(\\d+)/followers()()()()()()|/api/articles/(\\d+)()()()()()()()|/api/articles/(\\d+)/voters()()()()()()()()|/api/comments/(\\d+)()()()()()()()()()|/api/comments/(\\d+)/voters()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route85',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          3 => 
          array (
            0 => 'route90',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          4 => 
          array (
            0 => 'route92',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          5 => 
          array (
            0 => 'route101',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          6 => 
          array (
            0 => 'route102',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          7 => 
          array (
            0 => 'route106',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          8 => 
          array (
            0 => 'route114',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          9 => 
          array (
            0 => 'route118',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          10 => 
          array (
            0 => 'route119',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          11 => 
          array (
            0 => 'route131',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          12 => 
          array (
            0 => 'route132',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
        ),
      ),
      3 => 
      array (
        'regex' => '~^(?|/api/comments/(\\d+)/replies|/api/reports/([^/]+)\\:(\\d+)|/api/images/([^/]+)()()|/rss/questions/(\\d+)/answers()()()|/rss/users/(\\d+)/questions()()()()|/rss/users/(\\d+)/articles()()()()()|/rss/users/(\\d+)/answers()()()()()()|/rss/topics/(\\d+)/questions()()()()()()()|/rss/topics/(\\d+)/articles()()()()()()()()|/admin/(.+)()()()()()()()()()|/(.+)()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route137',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          3 => 
          array (
            0 => 'route140',
            1 => 
            array (
              'reportable_type' => 'reportable_type',
              'reportable_id' => 'reportable_id',
            ),
          ),
          4 => 
          array (
            0 => 'route156',
            1 => 
            array (
              'key' => 'key',
            ),
          ),
          5 => 
          array (
            0 => 'route160',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          6 => 
          array (
            0 => 'route162',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          7 => 
          array (
            0 => 'route163',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          8 => 
          array (
            0 => 'route164',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          9 => 
          array (
            0 => 'route165',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          10 => 
          array (
            0 => 'route166',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          11 => 
          array (
            0 => 'route167',
            1 => 
            array (
              'path' => 'path',
            ),
          ),
          12 => 
          array (
            0 => 'route170',
            1 => 
            array (
              'routes' => 'routes',
            ),
          ),
        ),
      ),
    ),
    'OPTIONS' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/api/(.+))$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route13',
            1 => 
            array (
              'routes' => 'routes',
            ),
          ),
        ),
      ),
    ),
    'POST' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/api/users/(\\d+)/followers|/api/users/(\\d+)/disable()|/api/users/([^/]+)/disable()()|/api/users/(\\d+)/enable()()()|/api/users/([^/]+)/enable()()()()|/api/topics/(\\d+)/trash()()()()()|/api/topics/([^/]+)/trash()()()()()()|/api/topics/(\\d+)/untrash()()()()()()()|/api/topics/([^/]+)/untrash()()()()()()()()|/api/topics/(\\d+)/followers()()()()()()()()()|/api/topics/(\\d+)()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route19',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          3 => 
          array (
            0 => 'route53',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          4 => 
          array (
            0 => 'route54',
            1 => 
            array (
              'user_ids' => 'user_ids',
            ),
          ),
          5 => 
          array (
            0 => 'route55',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          6 => 
          array (
            0 => 'route56',
            1 => 
            array (
              'user_ids' => 'user_ids',
            ),
          ),
          7 => 
          array (
            0 => 'route59',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          8 => 
          array (
            0 => 'route60',
            1 => 
            array (
              'topic_ids' => 'topic_ids',
            ),
          ),
          9 => 
          array (
            0 => 'route61',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          10 => 
          array (
            0 => 'route62',
            1 => 
            array (
              'topic_ids' => 'topic_ids',
            ),
          ),
          11 => 
          array (
            0 => 'route64',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          12 => 
          array (
            0 => 'route69',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
        ),
      ),
      1 => 
      array (
        'regex' => '~^(?|/api/questions/(\\d+)/comments|/api/questions/(\\d+)/trash()|/api/questions/([^/]+)/trash()()|/api/questions/(\\d+)/untrash()()()|/api/questions/([^/]+)/untrash()()()()|/api/questions/(\\d+)/followers()()()()()|/api/questions/(\\d+)/voters()()()()()()|/api/questions/(\\d+)/answers()()()()()()()|/api/answers/(\\d+)/comments()()()()()()()()|/api/answers/(\\d+)/trash()()()()()()()()()|/api/answers/([^/]+)/trash()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route73',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          3 => 
          array (
            0 => 'route76',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          4 => 
          array (
            0 => 'route77',
            1 => 
            array (
              'question_ids' => 'question_ids',
            ),
          ),
          5 => 
          array (
            0 => 'route78',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          6 => 
          array (
            0 => 'route79',
            1 => 
            array (
              'question_ids' => 'question_ids',
            ),
          ),
          7 => 
          array (
            0 => 'route81',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          8 => 
          array (
            0 => 'route86',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          9 => 
          array (
            0 => 'route91',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          10 => 
          array (
            0 => 'route93',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          11 => 
          array (
            0 => 'route96',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          12 => 
          array (
            0 => 'route97',
            1 => 
            array (
              'answer_ids' => 'answer_ids',
            ),
          ),
        ),
      ),
      2 => 
      array (
        'regex' => '~^(?|/api/answers/(\\d+)/untrash|/api/answers/([^/]+)/untrash()|/api/answers/(\\d+)/voters()()|/api/articles/(\\d+)/comments()()()|/api/articles/(\\d+)/trash()()()()|/api/articles/([^/]+)/trash()()()()()|/api/articles/(\\d+)/untrash()()()()()()|/api/articles/([^/]+)/untrash()()()()()()()|/api/articles/(\\d+)/followers()()()()()()()()|/api/articles/(\\d+)/voters()()()()()()()()()|/api/comments/(\\d+)/trash()()()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route98',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          3 => 
          array (
            0 => 'route99',
            1 => 
            array (
              'answer_ids' => 'answer_ids',
            ),
          ),
          4 => 
          array (
            0 => 'route103',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          5 => 
          array (
            0 => 'route107',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          6 => 
          array (
            0 => 'route110',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          7 => 
          array (
            0 => 'route111',
            1 => 
            array (
              'article_ids' => 'article_ids',
            ),
          ),
          8 => 
          array (
            0 => 'route112',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          9 => 
          array (
            0 => 'route113',
            1 => 
            array (
              'article_ids' => 'article_ids',
            ),
          ),
          10 => 
          array (
            0 => 'route115',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          11 => 
          array (
            0 => 'route120',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          12 => 
          array (
            0 => 'route126',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
        ),
      ),
      3 => 
      array (
        'regex' => '~^(?|/api/comments/([^/]+)/trash|/api/comments/(\\d+)/untrash()|/api/comments/([^/]+)/untrash()()|/api/comments/(\\d+)/voters()()()|/api/comments/(\\d+)/replies()()()()|/api/reports/([^/]+)\\:(\\d+)()()()()|/api/notifications/([^/]+)/read()()()()()()|/api/notifications/(\\d+)/read()()()()()()()|/(.+)()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route127',
            1 => 
            array (
              'comment_ids' => 'comment_ids',
            ),
          ),
          3 => 
          array (
            0 => 'route128',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          4 => 
          array (
            0 => 'route129',
            1 => 
            array (
              'comment_ids' => 'comment_ids',
            ),
          ),
          5 => 
          array (
            0 => 'route133',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          6 => 
          array (
            0 => 'route136',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          7 => 
          array (
            0 => 'route141',
            1 => 
            array (
              'reportable_type' => 'reportable_type',
              'reportable_id' => 'reportable_id',
            ),
          ),
          8 => 
          array (
            0 => 'route147',
            1 => 
            array (
              'notification_ids' => 'notification_ids',
            ),
          ),
          9 => 
          array (
            0 => 'route148',
            1 => 
            array (
              'notification_id' => 'notification_id',
            ),
          ),
          10 => 
          array (
            0 => 'route170',
            1 => 
            array (
              'routes' => 'routes',
            ),
          ),
        ),
      ),
    ),
    'DELETE' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/api/users/(\\d+)/followers|/api/users/(\\d+)/avatar()|/api/users/(\\d+)/cover()()|/api/topics/(\\d+)()()()|/api/topics/([^/]+)()()()()|/api/topics/(\\d+)/followers()()()()()|/api/questions/(\\d+)()()()()()()|/api/questions/([^/]+)()()()()()()()|/api/questions/(\\d+)/followers()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route20',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          3 => 
          array (
            0 => 'route25',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          4 => 
          array (
            0 => 'route26',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          5 => 
          array (
            0 => 'route57',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          6 => 
          array (
            0 => 'route58',
            1 => 
            array (
              'topic_ids' => 'topic_ids',
            ),
          ),
          7 => 
          array (
            0 => 'route65',
            1 => 
            array (
              'topic_id' => 'topic_id',
            ),
          ),
          8 => 
          array (
            0 => 'route74',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          9 => 
          array (
            0 => 'route75',
            1 => 
            array (
              'question_ids' => 'question_ids',
            ),
          ),
          10 => 
          array (
            0 => 'route82',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
        ),
      ),
      1 => 
      array (
        'regex' => '~^(?|/api/questions/(\\d+)/voters|/api/answers/(\\d+)()|/api/answers/([^/]+)()()|/api/answers/(\\d+)/voters()()()|/api/articles/(\\d+)()()()()|/api/articles/([^/]+)()()()()()|/api/articles/(\\d+)/followers()()()()()()|/api/articles/(\\d+)/voters()()()()()()()|/api/comments/(\\d+)()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route87',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          3 => 
          array (
            0 => 'route94',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          4 => 
          array (
            0 => 'route95',
            1 => 
            array (
              'answer_ids' => 'answer_ids',
            ),
          ),
          5 => 
          array (
            0 => 'route104',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          6 => 
          array (
            0 => 'route108',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          7 => 
          array (
            0 => 'route109',
            1 => 
            array (
              'article_ids' => 'article_ids',
            ),
          ),
          8 => 
          array (
            0 => 'route116',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          9 => 
          array (
            0 => 'route121',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          10 => 
          array (
            0 => 'route124',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
        ),
      ),
      2 => 
      array (
        'regex' => '~^(?|/api/comments/([^/]+)|/api/comments/(\\d+)/voters()|/api/reports/(\\S+,+\\S+)()()|/api/reports/([^/]+)\\:(\\d+)()()|/api/notifications/(\\d+)()()()()|/api/notifications/([^/]+)()()()()()|/api/images/(\\S+(?=.*,)\\S+)()()()()()()|/api/images/([^/]+)()()()()()()()|/(.+)()()()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route125',
            1 => 
            array (
              'comment_ids' => 'comment_ids',
            ),
          ),
          3 => 
          array (
            0 => 'route134',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          4 => 
          array (
            0 => 'route139',
            1 => 
            array (
              'report_targets' => 'report_targets',
            ),
          ),
          5 => 
          array (
            0 => 'route142',
            1 => 
            array (
              'reportable_type' => 'reportable_type',
              'reportable_id' => 'reportable_id',
            ),
          ),
          6 => 
          array (
            0 => 'route149',
            1 => 
            array (
              'notification_id' => 'notification_id',
            ),
          ),
          7 => 
          array (
            0 => 'route150',
            1 => 
            array (
              'notification_ids' => 'notification_ids',
            ),
          ),
          8 => 
          array (
            0 => 'route155',
            1 => 
            array (
              'keys' => 'keys',
            ),
          ),
          9 => 
          array (
            0 => 'route158',
            1 => 
            array (
              'key' => 'key',
            ),
          ),
          10 => 
          array (
            0 => 'route170',
            1 => 
            array (
              'routes' => 'routes',
            ),
          ),
        ),
      ),
    ),
    'PATCH' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/api/users/(\\d+)|/api/questions/(\\d+)()|/api/answers/(\\d+)()()|/api/articles/(\\d+)()()()|/api/comments/(\\d+)()()()()|/api/images/([^/]+)()()()()()|/(.+)()()()()()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route24',
            1 => 
            array (
              'user_id' => 'user_id',
            ),
          ),
          3 => 
          array (
            0 => 'route89',
            1 => 
            array (
              'question_id' => 'question_id',
            ),
          ),
          4 => 
          array (
            0 => 'route105',
            1 => 
            array (
              'answer_id' => 'answer_id',
            ),
          ),
          5 => 
          array (
            0 => 'route123',
            1 => 
            array (
              'article_id' => 'article_id',
            ),
          ),
          6 => 
          array (
            0 => 'route135',
            1 => 
            array (
              'comment_id' => 'comment_id',
            ),
          ),
          7 => 
          array (
            0 => 'route157',
            1 => 
            array (
              'key' => 'key',
            ),
          ),
          8 => 
          array (
            0 => 'route170',
            1 => 
            array (
              'routes' => 'routes',
            ),
          ),
        ),
      ),
    ),
    'PUT' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/(.+))$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route170',
            1 => 
            array (
              'routes' => 'routes',
            ),
          ),
        ),
      ),
    ),
  ),
);