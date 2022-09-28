<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous"
    />
</head>
<body>
<h4>New products have been added in last 24 hours. Login to see new product's details.</h4>
    <br>
    <p>Here is short list of new added products.</p>
    <br>

    @foreach($product as $item)
        <h5>Name: {{$item->name}}</h5>
        <h5>Description: {{$item->description}}</h5>
        <h5>Price: {{$item->price}} $</h5>
        <hr>
    @endforeach

    <br>
    <br>
    <button class="btn btn-success">
        <a href="http://localhost:3000/login">Login</a>
    </button>
    <br>
    <br>
    Thanks for being member of amazon community.
</body>
</html>
