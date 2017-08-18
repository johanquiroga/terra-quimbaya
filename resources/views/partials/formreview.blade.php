<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-star fa-2x text-primary"></i></span>
    <div class="form-group{{ $errors->has('calificacion') ? ' has-error' : '' }}">
        <label class="control-label" for="calificacion">Califica este producto</label>
        <input id="calificacion" name="calificacion" value="{{ $calificacion->calificacion or old("calificacion") }}" data-min="0" data-max="5" class="kv-ltr-theme-fa-star rating-loading" data-size="xs" required>
        @if ($errors->has('calificacion'))
            <span class="material-icons form-control-feedback">clear</span>
            <small class="text-danger">
                <strong>{{ $errors->first('calificacion') }}</strong>
            </small>
        @endif
    </div>
</div>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-comment fa-2x text-primary"></i></span>
    <div class="form-group label-floating{{ $errors->has('comentario') ? ' has-error' : '' }}">
        <label class="control-label" id="comentarioLabel" for="comentario" data-error="Incorrecto">Escribe lo que piensas del producto aquí...</label>
        <textarea id="comentario" class="form-control validate" name="comentario" rows="6" aria-describedby="comentarioLabel" maxlength="800">{{ $calificacion->comentario or old("comentario") }}</textarea>
        <strong><small id="charNumcomentarioHelp" class="text-muted">Tu comentario no debe sobrepasar los 800 caracteres. <div id="textarea_feedback"></div></small></strong>
        @if ($errors->has('comentario'))
            <span class="material-icons form-control-feedback">clear</span>
            <small class="text-danger">
                <strong>{{ $errors->first('comentario') }}</strong>
            </small>
        @endif
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#calificacion').rating({step: 0.5, theme: 'krajee-fa', language: 'es', showCaption: false});

            var text_max = 800;
            $('#textarea_feedback').html(text_max + ' caracteres restantes');

            $('#comentario').keyup(function() {
                var text_length = $('#comentario').val().length;
                var text_remaining = text_max - text_length;

                $('#textarea_feedback').html(text_remaining + ' caracteres restantes');
            });
        });
    </script>
@endsection