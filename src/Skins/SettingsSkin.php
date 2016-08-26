<?php
namespace OpenSeminar\TodoList\Skins;

use OpenSeminar\TodoList\Plugin;
use Xpressengine\Skin\AbstractSkin;
use View;

class SettingsSkin extends AbstractSkin
{
    /**
     * 클래스 이름으로 디렉토리 만들어서 사용
     *
     * @return mixed
     */
    public function render()
    {
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
