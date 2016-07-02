<nav class="top-bar" data-topbar role="navigation">

  <!-- Foundation suggests to keep it even if the title is not required -->
  <ul class="title-area">
    <li class="name">{{ HTML::link_to_ROUTE('index', 'BOOKING', array(), array()) }}</li>
  </ul>
    
  <section class="top-bar-section">

    <ul class="left">     <!-- Left Nav Section -->
      <li></li>
    </ul>

    <ul class="right">    <!-- Right Nav Section -->
      <!-- <li class="divider"></li> -->
      <li class="has-form">
        @if (Auth::check())
          {{ Form::open('logout', 'POST') }}
          {{ Form::token() }}
        
          <button type="submit">
            <i class="fi-lock"></i>Sign Out
          </button>
          {{ Form::close() }}
        @endif
      </li>
      
    </ul>
    
  </section>
</nav>
