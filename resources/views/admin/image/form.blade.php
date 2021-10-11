    @component('admin.component.select', [
        'name' => 'category_id',
        'title' => 'select category',
        'lists' => App\Model\Category::get()->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>[]
    ])@endcomponent

    @component('admin.component.select', [
       'name' => 'language',
       'title' => 'select Language',
       'lists' => \App\Model\Category::$languages,
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Enter language']
   ])@endcomponent

    {{--'lists' => App\Model\Category::selectRaw("*,CONCAT(name, ',', language) AS fullname")->get()->pluck('fullname','id'),--}}
    {{--@component('admin.component.select', [--}}
       {{--'name' => 'language',--}}
       {{--'title' => 'select Language',--}}
       {{--'lists' => \App\Model\Category::all('language'),--}}
       {{--'value'=>null,--}}
       {{--'required'=>true,--}}
       {{--'options'=>['placeholder'=>'Enter language']--}}
   {{--])@endcomponent--}}
    @component('admin.component.file', [
        'name' => 'preview_image',
        'title' => 'Upload Preview image',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent
    @component('admin.component.file', [
        'name' => 'frame_image',
        'title' => 'Upload Frame image',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent

    @if(!empty($record['frame_image_url']))
    <img src="{{ $record['frame_image_url'] }}" width="150">
    @endif
    @if(!empty($record['preview_image_url']))
        <img src="{{ $record['preview_image_url'] }}" width="150">
    @endif
