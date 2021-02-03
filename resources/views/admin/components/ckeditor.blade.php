<textarea name="{{$name}}" class="form-field @error($name) is-invalid @enderror" id="{{$id}}" rows="30" cols="80">
    {{$current_input}}
</textarea>

@section('script')
    @parent
    <script>
        var {{$id}} =  CKEDITOR.replace('{{$id}}', ckeditor_options);
    </script>
@endsection
