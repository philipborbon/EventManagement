@extends('layouts.jquery')

@section('content')
<div class="container">
  <h1>Upload User Identification</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('useridentifications') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('documenttypeid') ? ' has-error' : '' }}">
        <label for="documenttypeid" class="control-label">Document Type</label>

        <select id="documenttypeid" class="form-control" name="documenttypeid" autofocus>
        @foreach($types as $type)
        <option value="{{ $type->id }}" {{ old('documenttypeid') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
        </select>

        @if ($errors->has('documenttypeid'))
            <span class="help-block">
                <strong>{{ $errors->first('documenttypeid') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('attachment') ? ' has-error' : '' }}">
        <label for="attachment" class="control-label">Attachment</label>
        <div id="attachment" class="dropzone"></div>

        @if ($errors->has('attachment'))
            <span class="help-block">
                <strong>{{ $errors->first('attachment') }}</strong>
            </span>
        @endif
    </div>

  </form>
</div>
@endsection

@section('scripts')
<script>
var drop = new Dropzone('#attachment', {
    init: function() {
        this.on('maxfilesexceeded', function(file) {
            this.removeAllFiles();
            this.addFile(file);
        });

        this.on('sending', function(file, xhr, formData) {
            formData.append('documenttypeid', $('#documenttypeid').val());
        });

        this.on('success', function(file, responseText) {
            window.location.replace('/useridentifications');
        });
    },
    createImageThumbnails: true,
    addRemoveLinks: false,
    maxFiles: 1,
    maxFilesize: 5120,
    acceptedFiles: 'image/*',
    url: "{{ action('UserIdentificationController@upload') }}",
    headers: {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
    },
    removedfile: function(file){
        var name = file.name; 

        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            url: "{{ action('UserIdentificationController@removeFile') }}",
            data: { name: name },
            sucess: function(data){
                console.log('success: ' + data);
            }
        });

        var _ref;
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    }
});
</script>
@endsection