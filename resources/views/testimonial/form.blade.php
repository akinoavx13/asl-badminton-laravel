<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Ecrire un témoignage</h1>
    </div>
    <div class="ibox-content">
        {!! Form::open(['route' => 'testimonial.store', 'class' => 'form-horizontal', 'onsubmit' => 'return postForm()']) !!}

        <div class="form-group">
            <div class="col-md-12">
                {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'id' => 'summernote']) !!}
            </div>
        </div>

        <div class="form-group text-center">
            {!! Form::submit('Créer', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#summernote').summernote({
                height: "500px",
                disableDragAndDrop: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']]
                ]
            });

        });
        var postForm = function() {
            var content = $('textarea[name="content"]').html($('#summernote').code());
        }
    </script>
@stop