@component('admin.component.select', [
  'name' => 'active_ads',
  'title' => 'select Active ads',
  'lists' => \App\Model\Setting::$active_ads,
  'value'=>null,
  'required'=>true,
  'options'=>['placeholder'=>'Enter ad type','id'=>'active_ads']
])@endcomponent

<div class="admob">
@component('admin.component.text', [
    'name' => 'admob_app_id',
    'title' => 'ads mob id',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Admob app id']
])@endcomponent

@component('admin.component.text', [
    'name' => 'admob_banner_id',
    'title' => 'ads mob banner id',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Admob banner id']
])@endcomponent

@component('admin.component.text', [
    'name' => 'admob_fullscreen_id',
    'title' => 'ads mob fullscreen id',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Admob fullscreen id']
])@endcomponent

@component('admin.component.text', [
    'name' => 'admob_nativex_id',
    'title' => 'ads mob nativex id',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Admob nativex id']
])@endcomponent

</div>

<div class="facebook">
@component('admin.component.text', [
    'name' => 'facebook_banner_id',
    'title' => 'Facebook banner id',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Facebook banner id']
])@endcomponent

@component('admin.component.text', [
    'name' => 'facebook_fullscreen_id',
    'title' => 'Facebook fullscreen id',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Facebook fullscreen id']
])@endcomponent

</div>

