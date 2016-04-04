<html>
<head>
  <title></title>

  {{ HTML::style('css/jquery-ui.min.css') }}
  {{ HTML::style('css/normalize.css') }}
  {{ HTML::style('css/foundation.min.css') }}
  {{ HTML::style('css/base.css') }}

  {{ HTML::script('js/vendor/jquery.js') }}
  {{ HTML::script('js/foundation.min.js') }}
  {{ HTML::script('js/jquery-ui.min.js') }}
  {{ HTML::script('js/tinymce/tinymce.min.js') }}
    
</head>

<header style="margin-bottom: 20px;">
  <nav class="top-bar" data-topbar role="navigation">
    
    <ul class="title-area">
      <li class="name">
	<h1><a href="#">My Site</a></h1>
      </li>
      <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
      <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    </ul>
    
    <section class="top-bar-section">
      <!-- Left Nav Section -->
      <ul class="left">
	<li>{{ HTML::link_to_ROUTE('index', 'HOME', array(), array()) }}</li>
      </ul>

      <!-- Right Nav Section -->
      <ul class="right">
	<!-- <li class="has-dropdown"> -->
        <!--   <a href="#">Right Button Dropdown</a> -->
        <!--   <ul class="dropdown"> -->
        <!--     <li><a href="#">First link in dropdown</a></li> -->
        <!--     <li class="active"><a href="#">Active link in dropdown</a></li> -->
        <!--   </ul> -->
	<!-- </li> -->
	<li class="active"><a href="#">Right Button Active</a></li>
      </ul>
      
    </section>
  </nav>
</header>

<body>
  @if(Session::has('message'))
    {{ Session::get('message') }}
  @endif
  
  @yield('mainbody')
</body>
     
</html>
