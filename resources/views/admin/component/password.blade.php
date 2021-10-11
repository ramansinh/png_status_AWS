<div class="form-group {{ $errors->has($name) ? ' has-error' : '' }}">
    <label class="control-label">{{ $title }} {!! !empty($required) && $required==true?'<span class="text-danger">*</span>':'' !!} <small>(Leave blank if don't want to change)</small></label>
    {!! Form::password($name, ['class' => 'form-control'] + $options ) !!}
    {{--<span class="help-block" id="error_{{ $name }}"><strong>{{ $errors->first($name) }}</strong></span>--}}
</div>