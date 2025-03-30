<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h3>Customer index</h3>
    @foreach ($results as $result)
        @if ($result->feature === 'customer' && $result->rolename=== Auth::user()->role->name)
            <h2>{{$result->feature}}</h2>
            @php
                $permissionsArray = explode(',', $result->permissions);
            @endphp
            
            @foreach ($permissionsArray as $permission)
                @if( trim($permission) === 'create' )
                    <p>create</p>
                    <p>Feature_name : {{$result->feature}}</p>
                    <p>Role_name : {{$result->rolename}}</p>
                @endif
            @endforeach
                
            
        @endif
    @endforeach

</body>
</html>