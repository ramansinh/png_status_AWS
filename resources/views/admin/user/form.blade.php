@component('admin.component.text', [
    'name' => 'name',
    'title' => 'Name',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter name']
])@endcomponent
@component('admin.component.text', [
    'name' => 'email',
    'title' => 'Email',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter email']
])@endcomponent
@component('admin.component.password', [
    'name' => 'password',
    'title' => 'Password',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter password']
])@endcomponent
@component('admin.component.file', [
       'name' => 'image',
       'title' => 'Upload image',
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Choose file']
   ])@endcomponent

