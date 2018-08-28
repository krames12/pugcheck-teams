<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Import Character</h1>
    <div>
    </div>
    <form method="POST" action="/characters/import">
        {{ csrf_field() }}
        <label for="name">Character Name</label>
        <input type="text" id="name" name="name" />
        <label for="realm">Realm</label>
        <input type="text" id="realm" name="realm"  />
        <button type="submit">Import Character</button>
    </form>

    @include ('layouts.errors')
</body>
</html>