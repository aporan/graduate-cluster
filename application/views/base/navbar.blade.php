<nav class="top-bar" data-topbar role="navigation">

  <!-- Foundation suggests to keep it even if the title is not required -->
  <ul class="title-area">
    <li class="name">{{ HTML::link_to_ROUTE('index', 'BOOKING') }}</li>
  </ul>
    
  <section class="top-bar-section">

    <ul class="left">     <!-- Left Nav Section -->
      <li></li>
    </ul>

    <ul class="right">    <!-- Right Nav Section -->
      @if (Auth::check())

         @if (Auth::user()->type == 'admin') 
           <li class="has-form">
             <a class="button" href={{ URL::to_route('admin_index') }}>
               <i class="fi-widget"></i>Admin
             </a>
           </li>

           <li class="divider"></li>
         @endif
      
         <li class="has-form">

           {{ Form::open('logout', 'POST') }}
           {{ Form::token() }}
        
           <button type="submit">
             <i class="fi-lock"></i>Sign Out
           </button>
           {{ Form::close() }}

         </li>

      @endif
    </ul>
    
  </section>
</nav>
