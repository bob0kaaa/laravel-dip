@if($errors->any())
    <div style="background: #FF0000; padding: 10px; font-size: 18px;">
        <ul>
            @foreach($errors->all() as $message)
                <li>
                    {{ $message }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
