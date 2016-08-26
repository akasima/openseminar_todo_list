<?php
namespace OpenSeminar\TodoList;

use OpenSeminar\TodoList\Modules\TodoList;
use XeConfig;
use XePresenter;
use App\Http\Controllers\Controller;
use Xpressengine\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        // 관리 페이지 스킨 사용
        XePresenter::setSettingsSkinTargetId(TodoList::getId());
    }

    public function edit(Request $request, $id)
    {
        $config = XeConfig::get($this->getConfigName($id));

        return XePresenter::make('edit', [
            'id' => $id,
            'config' => $config,
        ]);
    }

    public function update(Request $request)
    {
        $this->addConfig($request->get('id'), $request->except(['id', '_token']));

        return redirect(route(sprintf('%s.settings.edit', Plugin::getId()), ['id' => $request->get('id')]));
    }

    protected function addConfig($id, $args)
    {
        // 설정은 계층을 갖을 수 있게 되어 있음
        // 상위 계층은 반드시 존재 해야 하므로 없을경우 빈 값으로 설정
        $baseConfig = XeConfig::get(Plugin::getId());
        if ($baseConfig === null) {
            XeConfig::add(Plugin::getId(), []);
        }

        // 인스턴스의 설정을 저장할 때 insert, update 구분
        $config = XeConfig::get($this->getConfigName($id));
        if ($config === null) {
            XeConfig::add($this->getConfigName($id), $args);
        } else {
            XeConfig::set($this->getConfigName($id), $args);
        }
    }

    // 인스턴스 설정을 저장할 이름 반환
    protected function getConfigName($id)
    {
        return sprintf('%s.%s', Plugin::getId(), $id);
    }
}
