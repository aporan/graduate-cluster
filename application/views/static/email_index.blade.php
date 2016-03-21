@layout('base.default')

@section('mainbody')
    <div class="page-center">
      {{ Form::open('', 'POST') }}
        {{ Form::token() }}

        <div class="row">
          <div class="large-10 large-centered columns">
	    {{ Form::textarea('allmail', null, array('id'=>'emailarea')) }}
          </div>
	</div>
      
      {{ Form::close() }}

    </div>


    <script>
      tinymce.init({
        selector: '#emailarea'
      });
    </script>

@endsection
