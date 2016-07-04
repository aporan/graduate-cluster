@layout('base.default')

@section('mainbody')

    <div class="row">
      <div class="large-3 columns">
        <a class="button expand main" href={{ URL::to_route('new_booking') }}>
          <i class="fi-plus"></i>NEW BOOKING
        </a>
      </div>

      <div class="large-3 columns">
        <a class="button expand main" href={{ URL::to_route('change_index') }}>
          <i class="fi-wrench"></i>CHANGE OF DESK
        </a>
      </div>

      <div class="large-3 columns">
        <a class="button expand main" href={{ URL::to_route('admin_index') }}>
          <i class="fi-results"></i>REPORT PAGE
        </a>
      </div>

      <div class="large-3 columns">
        <a class="button expand main" href={{ URL::to_route('email_index') }}>
          <i class="fi-mail"></i>SEND EMAILS
        </a>
      </div>
    </div>


    @include('booking.index')


@endsection
