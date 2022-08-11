@component('mail::message')
# Introduction

Your password is {{$password}},
<br>
Keep it in secret and don't tell anybody!!!

@component('mail::button', ['url' => 'http://localhost:3000/login'])
Complete verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
