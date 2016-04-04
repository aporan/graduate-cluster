<div class="row">
  <div class="small-10 large-10 columns">
    {{ Form::hidden('clus', e($cluster->id)) }}
    {{ Form::label('clusname', 'Cluster Name: ') }}
    {{ Form::text('clusname', Input::old('clusname')) }}
  </div>
  <div class="small-2 large-2 columns"></div>
</div>

<div class="row">
  <div class="small-10 large-10 columns">
    {{ Form::label('clusbuild', 'Building: ') }}
    {{ Form::text('clusbuild', Input::old('clusbuild')) }}
  </div>
  <div class="small-2 large-2 columns"></div>
</div>

<div class="row">
  <div class="small-10 large-10 columns">
    {{ Form::label('cluslev', 'Level: ') }}
    {{ Form::text('cluslev', Input::old('cluslev')) }}
  </div>
  <div class="small-2 large-2 columns"></div>
</div>

<div class="row">
  <div class="small-10 large-10 columns">
    {{ Form::label('clusseats', 'Max Seats: ') }}
    {{ Form::text('clusseats', Input::old('clusseats')) }}
  </div>
  <div class="small-2 large-2 columns"></div>
</div>

<div class="row">
  <div class="small-10 large-10 columns">
    {{ Form::file('cluster_image') }}
  </div>
  <div class="small-2 large-2 columns"></div>
</div>

<div class="row">
  <div class="small-6 large-6 columns">
    {{ Form::submit('UPDATE', array('class'=>'button tiny round')) }}
  </div>
  <div class="small-6 large-6 columns"></div>
</div>

