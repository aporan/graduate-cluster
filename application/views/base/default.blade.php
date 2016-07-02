<html>
  <head>
    <title></title>

    {{ HTML::style('css/jquery-ui.min.css') }}
    {{ HTML::style('css/normalize.css') }}
    {{ HTML::style('css/foundation.min.css') }}
    {{ HTML::style('css/foundation-icons.css') }}
    {{ HTML::style('css/base.css') }}

    {{ HTML::script('js/vendor/jquery.js') }}
    {{ HTML::script('js/foundation.min.js') }}
    {{ HTML::script('js/jquery-ui.min.js') }}
    {{ HTML::script('js/tinymce/tinymce.min.js') }}
    
  </head>

  <header style="margin-bottom: 20px;">
    {{ render('base.navbar') }}
  </header>

  <body>
    @if(Session::has('message'))
      <div id="alert" class="row">
        <div class="small-12 large-12 columns">
	  <div class="alert-box success">
	    {{ Session::get('message') }}
	    <a id="trig" href="#" class="close" onClick="alertClose(this.id)">⊗</a>
	  </div>
        </div>
      </div>
    @endif
  
    @yield('mainbody')

    @if(Session::has('message'))
      <script>
        function alertClose($id){
          var alert_id = $("#"+$id).closest("div").parent().parent().attr("id");
          $("#"+alert_id).slideUp("slow", function(){
              $(this).remove();
          });
        }
      </script>
    @endif  
    
  </body>
</html>
