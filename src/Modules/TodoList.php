<?php
namespace OpenSeminar\TodoList\Modules;

use OpenSeminar\TodoList\Plugin;
use Xpressengine\Menu\AbstractModule;
use Route;
use XeEditor;

class TodoList extends AbstractModule
{
    public static function boot()
    {
        ///* Code1-2
        // 라우트 등록
        static::registerInstanceRoute();
        //*/
    }

    ///* Code1-1
    // 인스턴스 라우트 등록
    protected static function registerInstanceRoute()
    {
        Route::instance(static::getId(), function() {
            Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);

            // Code4-1
            // create, store 추가. 글을 저장하는 store 는 post 로 처리
            Route::get('/create', ['as' => 'create', 'uses' => 'UserController@create']);
            Route::post('/store', ['as' => 'store', 'uses' => 'UserController@store']);

            // Code5-1
            Route::get('/{id}/show', ['as' => 'show', 'uses' => 'UserController@show']);

            // Code6-1
            // edit, update 추가. 글을 수정하는 update 는 post 로 처리
            Route::get('/{id}/edit', ['as' => 'edit', 'uses' => 'UserController@edit']);
            Route::post('/update', ['as' => 'update', 'uses' => 'UserController@update']);

            // Code7-1
            // 보통 삭제는 post 방식으로 처리하지만 코드 작성 편의상 get 방식으로 처리
            Route::get('/{id}/destroy', ['as' => 'destroy', 'uses' => 'UserController@destroy']);

        }, ['namespace' => 'OpenSeminar\TodoList']);
    }
    //*/

    ///* Code8-1
    protected static function registerSettingsRoute()
    {
        Route::settings(static::getId(), function() {
            Route::get('/{id}/edit', [
                'as' => sprintf('%s.settings.edit', Plugin::getId()), 'uses' => 'SettingsController@edit'
            ]);
            Route::post('/update', [
                'as' => sprintf('%s.settings.edit', Plugin::getId()), 'uses' => 'SettingsController@edit'
            ]);
        });
    }
    //*/

    /**
     * Return Create Form View
     * @return mixed
     */
    public function createMenuForm()
    {
        // TODO: Implement createMenuForm() method.
        return '';
    }

    /**
     * Process to Store
     *
     * @param string $instanceId to store instance id
     * @param array $menuTypeParams for menu type store param array
     * @param array $itemParams except menu type param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    public function storeMenu($instanceId, $menuTypeParams, $itemParams)
    {
        // TODO: Implement storeMenu() method.

        ///* Code4-4
        // 메뉴 생성할 때 ekditor 를 사용할 수 있도록 코드 추가
        XeEditor::setInstance($instanceId, 'editor/ckeditor@ckEditor');
        //*/
    }

    /**
     * Return Edit Form View
     *
     * @param string $instanceId to edit instance id
     *
     * @return mixed
     */
    public function editMenuForm($instanceId)
    {
        // TODO: Implement editMenuForm() method.
        return '';
    }

    /**
     * Process to Update
     *
     * @param string $instanceId to update instance id
     * @param array $menuTypeParams for menu type update param array
     * @param array $itemParams except menu type param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    public function updateMenu($instanceId, $menuTypeParams, $itemParams)
    {
        // TODO: Implement updateMenu() method.
    }

    /**
     * displayed message when menu is deleted.
     *
     * @param string $instanceId to summary before deletion instance id
     *
     * @return string
     */
    public function summary($instanceId)
    {
        // TODO: Implement summary() method.
        return '';
    }

    /**
     * Process to delete
     *
     * @param string $instanceId to delete instance id
     *
     * @return mixed
     */
    public function deleteMenu($instanceId)
    {
        // TODO: Implement deleteMenu() method.
    }

    /**
     * Get menu type's item object
     *
     * @param string $id item id of menu type
     * @return mixed
     */
    public function getTypeItem($id)
    {
        // TODO: Implement getTypeItem() method.
    }
}
