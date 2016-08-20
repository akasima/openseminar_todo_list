<form method="post" action="{{instanceRoute('update')}}">
    <!-- post 방식으로 할 때는 반드시 csrf_token 이 있어야함 -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{$item->id}}" />

    <input type="text" name="title" class="form-control" value="{{Input::old('title', $item->title)}}" />

    {!! editor($item->instanceId, [
      'content' => Input::old('content', $item->content),
    ]) !!}

    <button type="submit">수정</button>
</form>