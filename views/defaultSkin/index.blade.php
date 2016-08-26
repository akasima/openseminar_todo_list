기본 스킨
<div class="title">{{ $title }}</div>

<!-- Code8-5 -->
<!-- 설정을 사용해 제목 출력 -->
<h1>{{ $config === null ? '': $config->get('title')}}</h1>
<!-- end Code8-5 -->

<!-- Code4-2 -->
<a href="{{instanceRoute('create')}}" class="btn btn-primary">새로운 할일 등록</a>
<!-- end Code4-2 -->

<!-- Code3-2 -->
<table class="table">
    <thead>
        <tr>
            <th>제목</th>
        </tr>
    </thead>
    <tbody>
    @foreach($paginate as $item)
        <tr>
            <td>{{$item->title}}</td>
            <!-- Code5-2 -->
            <td><a href="{{instanceRoute('show', ['id' => $item->id])}}">{{$item->title}}</a></td>
            <!-- end Code5-2 -->
        </tr>
    @endforeach
    </tbody>
</table>

{!! $paginate->render() !!}
<!-- end Code3-2 -->