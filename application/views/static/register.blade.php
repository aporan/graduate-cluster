@layout('base.default')

@section('mainbody')

{{ render('error.validation') }}

<div class="large-4 large-centered columns">
  <div class="login-box">
    
    {{ Form::open('register/create', 'POST') }}
    {{ Form::token() }}
          
      <div class="row">
	<div class="large-12 columns">
          {{ Form::label('firstname', 'First Name') }}
	  {{ Form::text('firstname', Input::old('firstname')) }}
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
          {{ Form::label('lastname', 'Last Name') }}
	  {{ Form::text('lastname', Input::old('lastname')) }}
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
          {{ Form::label('email', 'Email') }}
	  {{ Form::text('email', Input::old('email')) }}
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
          {{ Form::label('password', 'Password') }}
	  {{ Form::password('password') }}
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
          {{ Form::label('password_confirmation', 'Confirm Password') }}
	  {{ Form::password('password_confirmation') }}
	</div>
      </div>
          
      <div class="row">
	<div class="large-12 large-centered columns">
	  <input type="submit" class="button expand" value="Log In"/>
	</div>
      </div>
	  

    {{ Form::close() }}

  </div>
</div>

{{ render('error.validation_js') }}
@endsection
