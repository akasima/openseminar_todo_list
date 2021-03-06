<?php
namespace OpenSeminar\TodoList\Skins;

use OpenSeminar\TodoList\Plugin;
use Xpressengine\Skin\AbstractSkin;
use View;
use XeFrontend;

class DefaultSkin extends AbstractSkin
{
    /**
     * 클래스 이름으로 디렉토리 만들어서 사용
     *
     * @return mixed
     */
    public function render()
    {
        ///* Code4-4
        // bootstrap 추가
//        XeFrontend::css('/plugins/openseminar_todo_list/assets/bootstrap/css/bootstrap.min.css')->appendTo('head')->load();
//        XeFrontend::js('/plugins/openseminar_todo_list/assets/bootstrap/js/bootstrap.min.js')->appendTo('head')->load();
        //*/

        $path = explode('\\', static::class);
        $viewDirectory = lcfirst(array_pop($path));

        return View::make(
            sprintf(
                '%s::views.%s.%s',
                Plugin::getId(),
                $viewDirectory,
                $this->view
            ),
            $this->data
        );
    }
}
