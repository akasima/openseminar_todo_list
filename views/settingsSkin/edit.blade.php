<form method="post" action="{{route(sprintf('%s.settings.update', OpenSeminar\TodoList\Plugin::getId()))}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="hidden" name="id" value="{{$id}}"/>

    <div class="form-group">
    <label>Todo 리스트 이름</label>
    <input type="title" name="title" class="form-control" value="{{$config == null ? '' : Input::old('title', $config->get('title'))}}" placeholder="Todo 리스트 이름"/>
    </div>

    <button type="submit" class="btn btn-primary">저장</button>
</form>