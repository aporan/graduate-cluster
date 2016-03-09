<html>
<head>
  <title></title>

  {{ HTML::style('css/normalize.css') }}
  {{ HTML::style('css/foundation.min.css') }}
  {{ HTML::style('css/base.css') }}

  {{ HTML::script('js/vendor/jquery.js') }}
  {{ HTML::script('js/foundation.min.js') }}
    
</head>

<header>
<!--TODO: Put Navbar here-->
</header>

<body>
  @if(Session::has('message'))
    {{ Session::get('message') }}
  @endif

  @yield('mainbody')
</body>
     
</html>
