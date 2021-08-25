@if(Session::has('success'))
    <div class="flash_messages success" id="flashMsg">
        <p>{{ Session::get('success') }}</p>
    </div>
@elseif(Session::has('error'))
    <div class="flash_messages error" id="flashMsg">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif