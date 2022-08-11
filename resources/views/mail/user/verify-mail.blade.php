@component('mail::message')
# Introduction

Your email is {{$email}}
<br>
To complete verification please follow to instructions.

@component('mail::button', ['url' => 'http://localhost:3000/verify/'.$email])
Complete verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
