@if($errors->has())
  <?php $i = 0; ?>
  @foreach ($errors->all() as $error)
    <?php $i++ ?>
    <div id="alerts_{{ $i }}" class="row">
      <div class="small-12 large-12 columns">
	<div class="alert-box alert">
	  {{ $error }}<br/>
	  <a id="trig_{{ $i }}" href="#" class="close" onClick="alertClose(this.id)">⊗</a>
	</div>
      </div>
    </div>
  @endforeach
@endif
