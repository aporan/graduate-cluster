@layout('base.default')

@section('mainbody')
    <div class="large-4 large-centered columns center">
      <div class="login-box">

	<div class="row">
	  <div class="large-12 columns">
	    <form>

	      <div class="row">
		<div class="large-12 columns">
		  <input type="text" name="username" placeholder="Username" />
		</div>
	      </div>

	      <div class="row">
		<div class="large-12 columns">
		  <input type="password" name="password" placeholder="Password" />
		</div>
	      </div>

	      <div class="row">
		<div class="large-12 large-centered columns">
		  <input type="submit" class="button expand" value="Log In"/>
		</div>
	      </div>
	      
	    </form>
	  </div>
	</div>
	
      </div>
    </div>
@endsection
