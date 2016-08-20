<?php
namespace OpenSeminar\TodoList;

use App\Http\Controllers\Controller;
use OpenSeminar\TodoList\Modules\TodoList;
use XePresenter;
use XeDB;
use XeDocument;
use XeTag;
use XeEditor;
use XeStorage;
use Auth;
use Xpressengine\Document\Models\Document;
use Xpressengine\Http\Request;
use Xpressengine\Routing\InstanceConfig;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;

class UserController extends Controller
{
    /** @var string  */
    protected $instanceId;

    /** @var array  */
    protected $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    public function __construct()
    {
        ///* Code2-1
        $instanceConfig = InstanceConfig::instance();
        $this->instanceId = $instanceConfig->getInstanceId();
        //*/

        XePresenter::setSkinTargetId(TodoList::getId());
    }

    public function index()
    {
        ///* Code3-1
        $perPage = 5;

        $paginate = Document::where('instanceId', $this->instanceId)
            ->orderBy('head', 'desc')
            ->paginate($perPage);

        return XePresenter::make('index', [
            'title' => 'Todo list',
            'paginate' => $paginate,
        ]);
        //*/

        return XePresenter::make('index', ['title' => 'Todo list']);
    }

    ///* Code4-3
    public function create()
    {
        // 로그인 안했으면 접근 권한 없다는 경고 출력
        if (Auth::check() === false) {
            throw new AccessDeniedHttpException;
        }

        return XePresenter::make('create', [
            'instanceId' => $this->instanceId,  // 에디터에서 사용
        ]);
    }
    //*/

    ///* Code4-5
    public function store(Request $request)
    {
        // 로그인 안했으면 접근 권한 없다는 경고 출력
        if (Auth::check() === false) {
            throw new AccessDeniedHttpException;
        }


        $this->validate($request, $this->rules);

        $inputs = $request->all();
        $inputs['instanceId'] = $this->instanceId;
        // 미들웨어에서 Purifying 된 content의 원본 데이터를 가져옴. content는 Html을 사용해야함.
        $inputs['content'] = $request->originAll()['content'];

        // 어디서 등록되었는지 구분
        $inputs['type'] = TodoList::getId();

        // 사용자 정보 처리
        $user = Auth::user();
        $inputs['userId'] = $user->getId();
        $inputs['writer'] = $user->getDisplayName();

        // 트랜젝션 시작
        XeDB::beginTransaction();

        // 문서 등록
        /** @var Document $doc */
        $doc = XeDocument::add($inputs);

        /** @var \Xpressengine\Editor\AbstractEditor $editor */
        $editor = XeEditor::get($this->instanceId);

        // 에디터에서 처리된 file, tag 연결
        $files = array_get($inputs, $editor->getFileInputName(), []);
        if (empty($files) === false) {
            XeStorage::sync($doc->getKey(), $files);
        }

        $tags = array_get($inputs, $editor->getTagInputName(), []);
        if (empty($tags) === false) {
            XeTag::set($doc->getKey(), $tags);
        }

        XeDB::commit();

        // 리스트 페이지로 이동
        return redirect(instanceRoute('index'));
    }
    //*/

    ///* Code5-1
    public function show($menuUrl, $id)
    {
        $item = Document::find($id);

        return XePresenter::make('show', [
            'item' => $item,
        ]);
    }
    //*/

    ///* Code6-3
    public function edit($menuUrl, $id)
    {
        $item = Document::find($id);

        // 글 작성자가 아니면 수정할 수 없음
        $user = Auth::user();
        if ($user->getId() != $item->userId) {
            throw new AccessDeniedHttpException;
        }

        return XePresenter::make('edit', [
            'item' => $item,
        ]);
    }
    //*/

    ///* Code6-4
    public function update(Request $request)
    {
        $item = Document::find($request->get('id'));

        // 글 작성자가 아니면 수정할 수 없음
        $user = Auth::user();
        if ($user->getId() != $item->userId) {
            throw new AccessDeniedHttpException;
        }

        $this->validate($request, $this->rules);

        $inputs = $request->all();
        $item->title = $inputs['title'];
        // 미들웨어에서 Purifying 된 content의 원본 데이터를 가져옴. content는 Html을 사용해야함.
        $item->content = $request->originAll()['content'];

        // 트랜젝션 시작
        XeDB::beginTransaction();

        // 문서 등록
        /** @var Document $doc */
        $doc = XeDocument::put($item);

        /** @var \Xpressengine\Editor\AbstractEditor $editor */
        $editor = XeEditor::get($this->instanceId);

        // 에디터에서 처리된 file, tag 연결
        $files = array_get($inputs, $editor->getFileInputName(), []);
        if (empty($files) === false) {
            XeStorage::sync($doc->getKey(), $files);
        }

        $tags = array_get($inputs, $editor->getTagInputName(), []);
        if (empty($tags) === false) {
            XeTag::set($doc->getKey(), $tags);
        }

        XeDB::commit();

        // 보기 페이지로 이동
        return redirect(instanceRoute('show', ['id' => $doc->id]));
    }
    //*/

    ///* Code7-3
    public function destroy($menuUrl, $id)
    {
        $item = Document::find($id);

        // 글 작성자가 아니면 수정할 수 없음
        $user = Auth::user();
        if ($user->getId() != $item->userId) {
            throw new AccessDeniedHttpException;
        }

        Document::destroy($id);

        // 리스트 페이지로 이동, 리스트 페이지로 이동 후 메시지 출력
        return redirect(instanceRoute('index'))->with(
            ['alert' => ['type' => 'success', 'message' => '삭제 되었습니다.']]
        );
    }
    //*/
}
