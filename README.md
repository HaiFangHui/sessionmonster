sessionmonster
==============

SessionMonster eats sessions in Laravel



# Why?

A theory is Varnish should always be caching all the traffic. If

* Response is a "function" of the current state
* The state is defined solely by the request body


However, if the request sent to Varnish does have any session cookie (`laravelsessionid=blahblah`), and since Varnish is not able to look into Laravel session storage system, it has to passthrough all the traffic for this request - no caching.

Also Varnish is not able to cache response from web servers if it returns with cookie.

Ideally, if there is no requirement for session storage, our application should not start a new session or load a session. If there is no new session created, there should be no cookie set from web application. In that case, Varnish should be aggressively caching all the traffic.

The target of this project is to delay the session cookie from being set, until doing so becomes meaningful.

For example, when a new client (A) comes to http://www.haifanghui.com/, he then goes to http://www.haifanghui.com/a/ to view all the news about Australian property market, during the whole process, there should be no session cookie set in his browser. However, when A goes to http://www.haifanghui.com/login and login, there _should be_ a session created - since the user's ID would be stored in it.


This project is used in HaiFangHui.com production site, and it serves us pretty good.
