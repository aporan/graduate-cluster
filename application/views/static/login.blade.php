@layout('base.default')

@section('mainbody')
<div class="large-4 large-centered columns page-centre">
  <div class="login-box">

    <form> <!-- Need to add form specifics -->
      
      <div class="row">
	<div class="large-12 columns">
          <label>Username</label>
	  <input type="text" name="username"/>
	</div>
      </div>
      
      <div class="row">
	<div class="large-12 columns">
          <label>Password</label>
	  <input type="password" name="password" />
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
@endsection
