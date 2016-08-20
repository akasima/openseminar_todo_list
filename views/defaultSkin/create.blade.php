<form method="post" action="{{instanceRoute('store')}}">
    <!-- post 방식으로 할 때는 반드시 csrf_token 이 있어야함 -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <input type="text" name="title" class="form-control" value="{{Input::old('title')}}" />

    {!! editor($instanceId, [
      'content' => Input::old('content'),
    ]) !!}

    <button type="submit">등록</button>
</form>