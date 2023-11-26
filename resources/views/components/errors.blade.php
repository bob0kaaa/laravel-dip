@if($errors->any())
    <div style="background: #FF0000; padding: 10px; font-size: 18px;">
        {{$errors->first()}}
    </div>
@endif
