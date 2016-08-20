<div>
    <div>제목 : {{$item->title}}</div>
    <div>
        {!! compile($item->instanceId, $item->content, true) !!}
    </div>
</div>

<a href="{{instanceRoute('index')}}" class="btn btn-primary">목록으로</a>

<!-- Code6-2 -->
<a href="{{instanceRoute('edit', ['id' => $item->id])}}" class="btn btn-primary">수정하기</a>
<!-- end Code6-2 -->

<!-- Code7-2 -->
<a href="{{instanceRoute('destroy', ['id' => $item->id])}}" class="btn btn-primary">삭제하기</a>
<!-- end Code7-2 -->