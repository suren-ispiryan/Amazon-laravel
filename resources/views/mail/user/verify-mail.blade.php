@component('mail::message')
# Introduction

Your token is {{$token}}
<br>
To complete verification please follow to instructions.

@component('mail::button', ['url' => 'http://localhost:3000/verify/'.$token])
Complete verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
