<h4>New products have been added in last 24 hours. Login to see new product's details.</h4>
<p>Here is short list of new added products.</p>
@foreach($product as $item)
    <h5>
        Name: {{$item->name}}
        <br>
        Description: {{$item->description}}
        <br>
        Price: {{$item->price}} $
    </h5>
        <hr>
@endforeach
@component('mail::button', ['url' => 'http://localhost:3000/login'])
    Login
@endcomponent
<h5>Thanks for being member of amazon community.</h5>
