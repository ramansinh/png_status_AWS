
    @component('admin.component.text', [
        'name' => 'name',
        'title' => 'Name',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter name']
    ])@endcomponent
    {{--@component('admin.component.select', [--}}
       {{--'name' => 'language',--}}
       {{--'title' => 'select Language',--}}
       {{--'lists' => \App\Model\Category::$languages,--}}
       {{--'value'=>null,--}}
       {{--'required'=>true,--}}
       {{--'options'=>['placeholder'=>'Enter language']--}}
   {{--])@endcomponent--}}
    @component('admin.component.file', [
        'name' => 'image',
        'title' => 'Upload Photo',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent


    @if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
    @endif
